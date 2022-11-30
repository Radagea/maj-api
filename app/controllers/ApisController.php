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
                        if (!$this->endpoint->enabled_get) {
                            throw new Exception('Method is not allowed', 405);
                        }

                        $this->getAction();
                        break;
                    case 'POST':
                        if (!$this->endpoint->enabled_post) {
                            throw new Exception('Method is not allowed', 405);
                        }

                        $this->postAction();
                        break;
                    case 'PUT':
                        if (!$this->endpoint->enabled_put) {
                            throw new Exception('Method is not allowed', 405);
                        }

                        $this->putAction();
                        break;
                    case 'DELETE':
                        if (!$this->endpoint->enabled_delete) {
                            throw new Exception('Method is not allowed', 405);
                        }

                        $this->deleteAction();
                        break;
                    default:
                        throw new Exception('Unrecognized method', 405);
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
