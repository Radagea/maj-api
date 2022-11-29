<?php

use Phalcon\Http\Response;

class ApisController extends ControllerApiBase
{

    public function indexAction()
    {
        $method = $this->request->getMethod();

        try {
            $this->client_ip = $_SERVER['REMOTE_ADDR'];

            $ip_arr = SecurityIp::getIpsAsArray($this->user_id);

            if (!empty($ip_arr)) {
                if (!in_array($this->client_ip, $ip_arr)) {
                    throw new Exception('Your IP is not in the access list',401);
                }
            }

            if ($this->isGlobal) {
                if ($this->global_endpoint->auth_req) {
                    echo "aha";
                }

                switch ($this->global_endpoint->endpoint_type) {
                    case 1:
                        $this->globalEndpointList();
                        break;
                    case 2:
                        $this->globalEndpointAuth();
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
        } catch (Exception $e) {
            if ($e->getCode()) {
                $this->putError($e->getMessage(), $e->getCode());
            } else {
                $this->putError($e->getMessage());
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
