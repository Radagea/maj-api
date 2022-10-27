<?php

use Phalcon\Security;

class LoginController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function doLoginAction()
    {
        try {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = Users::findFirst(
                [
                    'conditions' => 'username = :username:',
                    'bind' => [
                        'username' => $username
                    ]
                ]
            );

            $security = new Security();
            if ($user && $security->checkHash($password, $user->password))  {
                $this->flashSession->success('You logged in successfully!');
                $this->session->set('user_id', $user->id);
                $this->session->set('username', $user->username);
                $this->response->redirect('/');
            } else {
                throw new Exception('Your username or password is incorrect');
            }

        } catch (Exception $e) {
            $this->flashSession->error($e->getMessage());
            $this->response->redirect('/login');
        }
    }
}
