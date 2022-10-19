<?php

class EndpointsController extends ControllerBase
{
    public function indexAction()
    {
        /** @var Users $user */
        $user = Users::getUserById($this->session->get('user_id'));
        $this->view->user_uri = $user->unique_uri;
        $this->view->globalEndpoints = GlobalEndpoints::getGlobalEndpointsByUserId($user->id);
    }

    public function editAction()
    {
        try {
            if ($this->request->hasPost('globalSave')) {
                $this->globalEndPointEdit();
            } elseif ($this->request->hasPost('endpointSave')) {
                $this->endpointEdit();
            } else {
                throw new Exception('Something went wrong try again later');
            }
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
        $global_endpoint = GlobalEndpoints::findFirst('id = '.$endpoint_id);

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
        echo "nope";
    }
}