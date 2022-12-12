<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Escaper;
use \Phalcon\Mvc\Dispatcher as PhDispatcher;
use Phalcon\Dispatcher\Exception as DispatcherException;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();
    $di->set(
        'dispatcher',
        function() use ($di) {
            $evManager = $di->getShared('eventsManager');

            $evManager->attach(
                "dispatch:beforeException",
                function($event, $dispatcher, $exception)
                {
                    switch ($exception->getCode()) {
                        case DispatcherException::EXCEPTION_HANDLER_NOT_FOUND:
                        case DispatcherException::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward(
                                array(
                                    'controller' => 'error',
                                    'action'     => 'show404',
                                )
                            );
                            return false;
                    }
                }
            );
            $dispatcher = new PhDispatcher();
            $dispatcher->setEventsManager($evManager);
            return $dispatcher;
        },
        true
    );
    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    $session = new \Phalcon\Session\Manager();
    $escaper = new Escaper();
    $files = new \Phalcon\Session\Adapter\Stream(['savePath' => session_save_path()]);
    $session->setAdapter($files);
    $session->start();

    $di->set(
        'flashSession',
        function () use ($escaper, $session) {
            $flash = new FlashSession($escaper, $session);
            $flash->setCssClasses(
                [
                    'error'   => 'alert alert-danger',
                    'success' => 'alert alert-success',
                    'notice'  => 'alert alert-info',
                    'warning' => 'alert alert-warning',
                ]
            );
            return $flash;
        }
    );

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
