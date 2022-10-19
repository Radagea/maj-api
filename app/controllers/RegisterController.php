<?php

use Phalcon\Security;

class RegisterController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function doRegisterAction()
    {
        try {
            if ($this->request->getPost('password') !== $this->request->getPost('password-confirmation')) {
                throw new Exception('Your password is not the same');
            }

            $pass = $this->request->getPost('password');
            $username = $this->request->getPost('username');

            $user = Users::findFirst(
                [
                    'conditions' => 'username = :username:',
                    'bind' => [
                        'username' => $username,
                    ]
                ]
            );

            if ($user) {
                throw new Exception('User is already exists');
            }

            $security = new Security();
            $user = new Users();
            $user->username = $username;
            $user->password = $security->hash($pass);
            $user->email = $this->request->getPost('email');

            $user->createUri();
            $success = $user->save();

            if ($success) {
                $this->flashSession->success('Successfully registered');
                $this->response->redirect('/login');
            } else {
                throw new Exception('Something went wrong');
            }

        } catch(Exception $e) {
            $this->flashSession->error($e->getMessage());
            $this->response->redirect('/register');
        }
    }
}