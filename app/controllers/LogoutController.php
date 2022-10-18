<?php

class LogoutController extends ControllerBase
{
    public function indexAction()
    {
        $this->flashSession->success('You logged out!');
        $this->session->remove('user_id');
        $this->session->remove('username');
        $this->response->redirect('/login');
    }
}