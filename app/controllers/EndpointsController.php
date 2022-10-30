<?php

class EndpointsController extends ControllerBase
{
    public function indexAction()
    {
        $this->assets->addJs('js/ge_add_user_group.js');
        /** @var Users $user */
        $user = Users::getUserById($this->session->get('user_id'));
        $this->view->user_uri = $user->unique_uri;
        $this->view->globalEndpoints = GlobalEndpoints::getGlobalEndpointsByUserId($user->id);
        $this->view->endpointCount = Endpoints::countUserEndpoints($user->id);
        $this->view->endpointsTest = Endpoints::find([
            'conditions' => 'user_id = :user_id:',
            'bind' => [
                'user_id' => $this->session->get('user_id'),
            ],
        ]);
        $this->view->user_groups = GeAuthUserGroups::getFromUserId($user->id);
        $this->view->old_groups_id = $this->makeOldGroupsid($this->view->user_groups);
    }

    protected function makeOldGroupsid($user_groups)
    {
        $string = '';
        foreach ($user_groups as $user_group) {
            $identifier = $user_group->unique_identifier;
            $string .= $identifier . ',';
        }
        return substr($string, 0, -1);
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

    public function createAction()
    {
        try {
            if (!$this->request->hasPost('createEndpoint')) {
                throw new Exception('There is a problem');
            }

            if (Endpoints::countUserEndpoints($this->session->get('user_id')) === 15) {
                throw new Exception('You have too many endpoints');
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

        //User groups for the authentication global endpoints
        if ($global_endpoint->endpoint_type == 2) {
            $new_groups = explode(',', $this->request->getPost('new-groups'));
            $deleted_old_groups = explode(',', $this->request->getPost('deleted-old-groups'));
            $old_groups = explode(',', $this->request->getPost('old-groups'));
            $default = $this->request->getPost('default-user-group-radio');

            //NEW GROUPS
            foreach ($new_groups as $new_group) {
                $user_group = new GeAuthUserGroups();
                $user_group->setUserId($this->session->get('user_id'));
                $user_group->setGeId($global_endpoint->id);
                $user_group->name = $this->request->getPost($new_group . '-name');
                $user_group->unique_identifier = GeAuthUserGroups::createUniqId($global_endpoint->user->username);
                if ($new_group == $default) {
                    $user_group->is_default = 1;
                } else {
                    $user_group->is_default = 0;
                }
                $success = $user_group->save();
            }

            //Old groups
            foreach ($old_groups as $old_group) {
                /** @var GeAuthUserGroups $user_group */
                $user_group = GeAuthUserGroups::getFirstFromUserIdAndUniqId($this->session->get('user_id'), $old_group);
                $user_group->name = $this->request->getPost($old_group . '-name');
                if ($old_group == $default) {
                    $user_group->is_default = 1;
                } else {
                    $user_group->is_default = 0;
                }
                $success = $user_group->save();
            }

            //Deleted old groups
            foreach ($deleted_old_groups as $deleted_old_group) {
                /** @var GeAuthUserGroups $user_group */
                $deleted_user_group = GeAuthUserGroups::getFirstFromUserIdAndUniqId($this->session->get('user_id'), $deleted_old_group);
                //TODO replace all users in this group into the default one
                if($deleted_user_group != null) {
                    $success = $deleted_user_group->delete();
                }
            }
        }

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
