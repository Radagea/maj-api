<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        if ($dispatcher->getControllerName() !== 'login' && $dispatcher->getControllerName() !== 'register') {
            if (!$this->session->has('user_id')) {
                $this->response->redirect('/login');
            }
        } else {
            if($this->session->has('user_id')) {
                $this->response->redirect('/');
            }
        }
    }
}
