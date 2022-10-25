<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerApiBase extends Controller
{
    protected $endpoint;
    protected string $user_uri;
    protected int $user_id;
    protected string $endpoint_uri;

    public function initialize()
    {
        $headers = $this->response->getHeaders();
        $headers->set('Content-Type', 'application/json');
        $this->response->setHeaders($headers);

    }


    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        try {
            if (!$this->user_uri = $this->dispatcher->getParam('user_uri')) {
                throw new Exception('user nope');
            }

            if (!$this->endpoint_uri = $this->dispatcher->getParam('endpoint')) {
                throw new Exception('endpoint is missing');
            }

            if (!$this->user_id = Users::getUserIdByUniqueUri($this->user_uri)) {
                throw new Exception('user not found');
            }

            if (!$this->endpoint = Endpoints::getEndpointByUserAndEndpointUri($this->user_id, $this->endpoint_uri) ) {
                throw new Exception('Endpoint is not valid');
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            print_r($this->endpoint);
        }
    }

    public function indexAction()
    {
        $this->response->send();
        die();
    }
}