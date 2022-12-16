<?php

declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Security;

class ControllerApiBase extends Controller
{
    //CONST Declarations
    const AUTH_REGISTER_TYPE = 'authreg';
    const AUTH_LOGIN_TYPE = 'authlog';
    const AUTH_USERS_TYPE = 'authusers';

    /** @var Endpoints $endpoint */
    protected $endpoint;

    /** @var GlobalEndpoints $global_endpoint */
    protected $global_endpoint;
    protected $isGlobal = false;

    protected $user_uri;
    protected $user_id;
    protected string $endpoint_uri;

    /** @var GeAuthUsers $ge_auth_user */
    protected $ge_auth_user;

    protected $client_ip;

    protected $response_content;
    protected $request_content;

    public function initialize()
    {
        $headers = $this->response->getHeaders();
        $headers->set('Content-Type', 'application/json');
        $this->response->setHeaders($headers);
        $this->request_content = $this->request->getJsonRawBody();
    }

    public function indexAction()
    {
        $this->response->setJsonContent($this->response_content);
        $this->response->send();
        die();
    }

    //Global LIST API
    public function globalEndpointList()
    {
        $this->response_content['num'] = Endpoints::countUserEndpoints($this->user_id);
        $endpoints = Endpoints::getEndpointsByUserId($this->user_id);
        $endpoints_to_content = [];
        foreach ($endpoints as $endpoint) {
            $endpoints_to_content[] = [
                'endpoint_name' => $endpoint->endpoint_name,
                'description' => $endpoint->description,
                'uri' => $endpoint->endpoint_uri,
                'enabled' => $endpoint->enabled,
                'auth_req' => $endpoint->auth_req,
            ];
        }
        $this->response_content['endpoints'] = $endpoints_to_content;
    }
    //End of global LIST API

    //Global Authentication API functions
    public function globalEndpointAuth()
    {
        $method = $this->request->getMethod();

        try {
            if ($method != 'POST' && $method != 'GET' && $method != 'PUT') {
                throw new Exception('This HTTP method is not supported yet');
            }
            if ($method === 'POST') {
                if (!isset($this->request_content->action)) {
                    throw new Exception('Request action has not found please check the documentation');
                }
                if ($this->request_content->action == 'register') {
                    $this->globalEndpointAuth_POST_register();
                } else {
                    if ($this->request_content->action == 'login') {
                        $this->globalEndpointAuth_POST_login();
                    } else {
                        throw new Exception('This request action does not supported yet');
                    }
                }
            }

            if ($method === 'GET') {
                $this->response_content = ['message' => 'asd'];
            }

            if ($method === 'PUT') {
                $this->globalEndpointAuth_PUT_users();
            }
        } catch (Exception $e) {
            if ($e->getCode()) {
                $this->putError($e->getMessage(), $e->getCode());
            } else {
                $this->putError($e->getMessage());
            }
        }
    }

    /**
     * @throws Exception
     */
    protected function globalEndpointAuth_POST_register()
    {
        $this->checkFields($this->request_content, self::AUTH_REGISTER_TYPE);
        $email = $this->request_content->user_data->email;
        $pass = $this->request_content->user_data->password;
        $ge_auth_user_group = GeAuthUserGroups::getDefaultFromUserId($this->user_id);
        $GeAuthUser = GeAuthUsers::findFirst([
            'conditions' => 'email = :email: AND main_user_id= :main_user_id:',
            'bind' => [
                'email' => $email,
                'main_user_id' => $this->user_id,
            ],
        ]);

        if ($GeAuthUser) {
            throw new Exception('User is already exists');
        }

        $security = new Security();

        $GeAuthUser = new GeAuthUsers();
        $GeAuthUser->email = $email;
        $GeAuthUser->password = $security->hash($pass);
        $GeAuthUser->main_user_id = $this->user_id;
        $GeAuthUser->setUserGroupId($ge_auth_user_group->id);
        $GeAuthUser->save();

        $ge_auth_user_group->count++;
        $ge_auth_user_group->save();

        $this->response_content['code'] = 1;
        $this->response_content['message'] = 'Successfully registered';
    }

    /**
     * @throws Exception
     */
    protected function globalEndpointAuth_POST_login()
    {
        $this->checkFields($this->request_content, self::AUTH_LOGIN_TYPE);
        $email = $this->request_content->user_data->email;
        $pass = $this->request_content->user_data->password;

        $GeAuthUser = GeAuthUsers::findFirst([
           'conditions' => 'email = :email: AND main_user_id = :user_id:',
            'bind' => [
                'email' => $email,
                'user_id' => $this->user_id
            ]
        ]);

        $security = new Security();
        if ($GeAuthUser && $security->checkHash($pass, $GeAuthUser->password)) {
            $this->response_content['code'] = 2;
            $this->response_content['message'] = 'Logged in';
            $this->response_content['user_id'] = $GeAuthUser->id;
            $this->response_content['token'] = $GeAuthUser->getToken();
            $this->response_content['expires_at'] = $GeAuthUser->expires_at;
        } else {
            throw new Exception('User not exists or password is incorrect', 3);
        }
    }

    /**
     * @throws Exception
     */
    protected function globalEndpointAuth_PUT_users()
    {
        $this->checkFields($this->request_content, self::AUTH_USERS_TYPE);

        if ($this->ge_auth_user = GeAuthUsers::getUserByToken($this->request_content->user_token)) {
            if ($this->ge_auth_user->user_group->ge_id == $this->global_endpoint->id && $this->ge_auth_user->user_group->is_admin) {
                $user_id = $this->request_content->user_id;
                /** @var GeAuthUserGroups $new_group */
                $new_group = GeAuthUserGroups::getByUniqueId($this->request_content->user_group_unique);
                /** @var GeAuthUsers $user */
                $user = GeAuthUsers::findFirst($user_id);
                if  (!$user || $user->main_user_id != $this->user_id) {
                    throw new Exception('No user with this ID', 400);
                }

                $old_group = $user->user_group;
                $old_group->count = $old_group->count--;
                $old_group->save();
                $user->setUserGroupId($new_group->id);
                $user->save();
                $new_group->count = $new_group->count+1;
                $new_group->save();
                $this->response_content = [
                    'code' => 2,
                    'message' => 'User successfully moved into the ' . $new_group->name,
                ];
            } else {
                throw new Exception('Your account cant access to this endpoint', 401);
            }
        } else {
            throw new Exception('Invalid user', 401);
        }
    }
    //End of Authentication API functions

    //Check globals has required fields
    /**
     * @throws Exception
     */
    protected function checkFields($arr, $type)
    {
        if ($type === self::AUTH_REGISTER_TYPE || $type === self::AUTH_LOGIN_TYPE) {
            if ((!isset($arr->user_data)) || (!isset($arr->user_data->email)) || (!isset($arr->user_data->password))) {
                throw new Exception('One of the required fields is missing, check documentation');
            }
        }

        if ($type === self::AUTH_USERS_TYPE) {
            if ((!isset($arr->user_token)) || (!isset($arr->user_id)) || (!isset($arr->user_group_unique))) {
                throw new Exception('One of the required fields is missing, check documentation');
            }
        }
    }

    public function putError($message, $code = 404)
    {
        $this->response_content = [
            'response_code' => $code,
            'message' => $message,
        ];
        $status_codes = [404,400,200,300,301,500,401];
        if (in_array($code, $status_codes)) {
            $this->response->setStatusCode($code);
        } else {
            $this->response->setStatusCode(200);
        }
    }

}
