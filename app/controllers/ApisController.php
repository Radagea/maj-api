<?php

use Phalcon\Http\Response;

class ApisController extends ControllerApiBase
{

    public function indexAction()
    {
        $method = $this->request->getMethod();

        if ($this->isGlobal) {
            switch ($this->global_endpoint->endpoint_type) {
                case 1:
                    $this->globalEndpointList();
                    break;
                case 2:
                    $this->globalEndpointAuth();
                    break;
                case 3:
                    $this->globalEndpointAuthUser();
                    break;
                default:
                    $this->putError('Endpoint is invalid');
                    break;
            }
        } else {
            switch($method) {
                case 'GET':
                    $this->getAction();
                    break;
                case 'POST':
                    $this->postAction();
                    break;
                case 'PUT':
                    $this->putAction();
                    break;
                case 'DELETE':
                    $this->deleteAction();
                    break;
                default:
                    $this->putError('Unrecognized method', 405);
                    break;
            }
        }

        parent::indexAction();
    }

    protected function getAction()
    {
        $this->response_content['type'] = 'GET';
    }

    protected function postAction()
    {
        $this->response_content['type'] = 'POST';
    }

    protected function putAction()
    {
        $this->response_content['type'] = 'PUT';
    }

    protected function deleteAction()
    {
        $this->response_content['type'] = 'DELETE';
    }
}