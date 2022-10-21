<?php

class EndpointsController extends ControllerBase
{
    public function indexAction()
    {
        /** @var Users $user */
        $user = Users::getUserById($this->session->get('user_id'));
        $this->view->user_uri = $user->unique_uri;
        $this->view->globalEndpoints = GlobalEndpoints::getGlobalEndpointsByUserId($user->id);

        $this->view->endpointsTest = Endpoints::find([
            'conditions' => 'user_id = :user_id:',
            'bind' => [
                'user_id' => $this->session->get('user_id')
            ]
        ]);
    }

    public function editAction()
    {
        try {
            if ($this->request->hasPost('globalSave')) {
                $this->globalEndPointEdit();
            } elseif ($this->request->hasPost('endpointSave')) {
                $this->endpointEdit();
            } elseif ($this->request->hasPost('endpointDelete')) {
                $this->endpointDelete();
            } else {
                throw new Exception('Something went wrong try again later');
            }
        } catch (Exception $e) {
            $this->flashSession->error($e->getMessage());
        }


        $this->response->redirect('/endpoints');
    }

    public function createAction(){
        try {
            if (!$this->request->hasPost('createEndpoint')) {
                throw new Exception('There is a problem');
            }

            $endpoint = new Endpoints();
            $endpoint->user_id = $this->session->get('user_id');
            $endpoint->endpoint_name = $this->request->getPost('endpoint-name');

            if ($this->request->hasPost('isEnabled')) {
                $endpoint->enabled = 1;
            } else {
                $endpoint->enabled = 0;
            }

            if ($this->request->hasPost('isAuthReq')) {
                $endpoint->auth_req = 1;
            } else {
                $endpoint->auth_req = 0;
            }

            if ($this->request->hasPost('endpoint-uri') && $this->request->getPost('endpoint-uri') != '') {
                $endpoint->endpoint_uri = Endpoints::normalizeURI($this->request->getPost('endpoint-uri'), $this->session->get('user_id'));
            } else {
                $endpoint->endpoint_uri = Endpoints::normalizeURI($endpoint->endpoint_name, $this->session->get('user_id'));
            }

            $endpoint->description = $this->request->getPost('endpoint-desc');

            $success = $endpoint->save();

            if (!$success) {
                foreach ($endpoint->getMessages() as $message) {
                    echo $message . PHP_EOL;
                }
                die();
            }

            $this->flashSession->success('Endpoint successfully created');
        } catch (Exception $e) {
            $this->flashSession->error($e->getMessage());
        }
        $this->response->redirect('/endpoints');
    }

    protected function globalEndPointEdit()
    {
        $endpoint_id = $this->request->get('id');
        if (GlobalEndpoints::hasPermission($endpoint_id, $this->session->get('user_id')) < 1) {
            throw new Exception("You don't have permission to edit this endpoint");
        }

        /** @var GlobalEndpoints $global_endpoint */
        $global_endpoint = GlobalEndpoints::findFirst('id = ' . $endpoint_id);

        if ($this->request->hasPost('isEnabled')) {
            $global_endpoint->enabled = 1;
        } else {
            $global_endpoint->enabled = 0;
        }

        if ($this->request->hasPost('isAuthReq')) {
            $global_endpoint->auth_req = 1;
        } else {
            $global_endpoint->auth_req = 0;
        }

        $success = $global_endpoint->update();
        if ($success) {
            $this->flashSession->success('Endpoint has been saved');
        }
    }

    protected function endpointEdit()
    {
        $endpoint_id = $this->request->get('id');

        if (Endpoints::hasPermission($endpoint_id, $this->session->get('user_id')) < 1) {
            throw new Exception("You don't have permission to edit this endpoint");
        }

        /** @var Endpoints $endpoint */
        $endpoint = Endpoints::findFirst('id = ' . $endpoint_id);

        $endpoint->endpoint_name = $this->request->getPost('endpoint-name');

        if ($this->request->hasPost('isEnabled')) {
            $endpoint->enabled = 1;
        } else {
            $endpoint->enabled = 0;
        }

        if ($this->request->hasPost('isAuthReq')) {
            $endpoint->auth_req = 1;
        } else {
            $endpoint->auth_req = 0;
        }

        $endpoint->dataset_id = 0;
        $endpoint->endpoint_uri = $this->request->getPost('endpoint-uri');
        $endpoint->description = $this->request->getPost('endpoint-desc');

        $success = $endpoint->save();

        if ($success) {
            $this->flashSession->success('Endpoint has been saved');
        } else {
            foreach ($endpoint->getMessages() as $message) {
                echo $message . PHP_EOL;
            }
            die();
        }
    }

    protected function endpointDelete()
    {
        $endpoint_id = $this->request->get('id');

        if (Endpoints::hasPermission($endpoint_id, $this->session->get('user_id')) < 1) {
            throw new Exception("You don't have permission to delete this endpoint");
        }

        /** @var Endpoints $endpoint */
        $endpoint = Endpoints::findFirst('id = ' . $endpoint_id);

        $success = $endpoint->delete();

        if ($success) {
            $this->flashSession->success('Endpoint successfully deleted');
        } else {
            foreach ($endpoint->getMessages() as $message) {
                echo $message . PHP_EOL;
            }
            die();
        }
    }
}