<?php
declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerApiBase extends Controller
{
    /** @var Endpoints $endpoint*/
    protected $endpoint;

    /** @var GlobalEndpoints $global_endpoint */
    protected $global_endpoint;
    protected $isGlobal = false;

    protected string $user_uri;
    protected $user_id;
    protected string $endpoint_uri;

    protected $response_content;

    public function initialize()
    {
        $headers = $this->response->getHeaders();
        $headers->set('Content-Type', 'application/json');
        $this->response->setHeaders($headers);
    }

    public function indexAction()
    {
        $this->response->setJsonContent($this->response_content);
        $this->response->send();
        die();
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
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

        } catch (Exception $e) {
            if ($e->getCode()) {
                $this->putError($e->getMessage(), $e->getCode());
            } else {
                $this->putError($e->getMessage());
            }
        }
    }

    public function putError($message, $code = 404)
    {
        $this->response_content = [
            'response_code' => $code,
            'message' => $message,
        ];
        $this->response->setStatusCode($code);
    }

    public function globalEndpointList()
    {
        $this->response_content['num'] = Endpoints::countUserEndpoints($this->user_id);
        $endpoints = Endpoints::getEndpointsByUserId($this->user_id);
        $endpoints_to_content = [];
        foreach ($endpoints as $endpoint) {
            $endpoints_to_content[] = [
                'id' => $endpoint->id,
                'endpoint_name' => $endpoint->endpoint_name,
                'description' => $endpoint->description,
                'uri' => $endpoint->endpoint_uri,
                'enabled' => $endpoint->enabled,
                'auth_req' => $endpoint->auth_req,
            ];
        }
        $this->response_content['endpoints'] = $endpoints_to_content;
    }

    public function globalEndpointAuthUser()
    {
        $this->response_content['message'] = 'auth-user';
    }

    public function globalEndpointAuth()
    {
        $this->response_content['message'] = 'auth';
    }
}