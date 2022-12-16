<?php

use Phalcon\Http\Response;

class ApisController extends ControllerApiBase
{

    public function indexAction()
    {
        try {
            if (!$this->user_uri = $this->dispatcher->getParam('user_uri')) {
                throw new Exception('The primary endpoint is not found');
            }

            if (!$this->endpoint_uri = $this->dispatcher->getParam('endpoint')) {
                throw new Exception('The secondary endpoint is not found');
            }

            if (!$this->user_id = Users::getUserIdByUniqueUri($this->user_uri)) {
                throw new Exception('The primary endpoint is not found');
            }

            if (!$this->endpoint = Endpoints::getEndpointByUserAndEndpointUri($this->user_id, $this->endpoint_uri)) {
                if (!$this->global_endpoint = GlobalEndpoints::getEndpointByUserAndEndpointUri($this->user_id, $this->endpoint_uri)) {
                    throw new Exception('The secondary endpoint is not found');
                } else {
                    $this->isGlobal = true;
                }
            }

            $method = $this->request->getMethod();
            $this->client_ip = $_SERVER['REMOTE_ADDR'];

            $ip_arr = SecurityIp::getIpsAsArray($this->user_id);

            if (!empty($ip_arr)) {
                if (!in_array($this->client_ip, $ip_arr)) {
                    throw new Exception('Your IP is not in the access list',401);
                }
            }

            if ($this->isGlobal) {
                if ($this->global_endpoint->auth_req) {
                    if (isset($this->request_content->user_token)) {
                        if ($this->ge_auth_user = GeAuthUsers::getUserByToken($this->request_content->user_token)) {
                            if (!in_array($this->ge_auth_user->user_group->id, $this->global_endpoint->group_settings)) {
                                throw new Exception('Your account cant access to this endpoint', 401);
                            }
                        } else {
                            throw new Exception('Invalid user', 401);
                        }
                    } else {
                        throw new Exception('Please first login or use user_token ', 401);
                    }
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
                if ($this->endpoint->auth_req) {
                    if (isset($this->request_content->user_token)) {
                        if ($this->ge_auth_user = GeAuthUsers::getUserByToken($this->request_content->user_token)) {
                            switch ($method) {
                                case 'GET':
                                        if (!in_array($this->ge_auth_user->user_group->id, $this->endpoint->get_allowed_groups)){
                                            throw new Exception('Your account cant access to this endpoint with this method', 401);
                                        }
                                    break;
                                case 'POST':
                                    if (!in_array($this->ge_auth_user->user_group->id, $this->endpoint->post_allowed_groups)){
                                        throw new Exception('Your account cant access to this endpoint with this method', 401);
                                    }
                                    break;
                                case 'PUT':
                                    if (!in_array($this->ge_auth_user->user_group->id, $this->endpoint->put_allowed_groups)){
                                        throw new Exception('Your account cant access to this endpoint with this method', 401);
                                    }
                                    break;
                                case 'DELETE':
                                    if (!in_array($this->ge_auth_user->user_group->id, $this->endpoint->delete_allowed_groups)){
                                        throw new Exception('Your account cant access to this endpoint with this method', 401);
                                    }
                                    break;
                            }
                        } else {
                            throw new Exception('Invalid user', 401);
                        }
                    } else {
                        throw new Exception('Please first login or use user_token ', 401);
                    }
                }
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
