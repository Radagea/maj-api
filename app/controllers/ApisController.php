<?php

use Phalcon\Http\Response;

class ApisController extends ControllerApiBase
{

    public function indexAction()
    {
        $contents = [
            'welcome' => 'Hello World!',
            'user' => $this->user_uri,
            'user_id' => $this->user_id,
            'endpoint' => $this->endpoint_uri,
            'type' => 'API',
        ];

        $this->response->setJsonContent($contents);

        parent::indexAction();
    }
}