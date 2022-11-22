<?php

class SecurityController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->securityips = SecurityIp::find([
            'conditions' => 'user_id = :user_id:',
            'bind' => [
                'user_id' => $this->session->get('user_id'),
            ]
        ]);
    }

    public function deleteipAction()
    {
        try {
            if (!$this->request->get('ip_id')) {
                throw new Exception('Permission denied');
            }

            $security_ip = SecurityIp::findFirst('id = ' . $this->request->get('ip_id'));

            if ($security_ip->user_id !== $this->session->get('user_id')) {
                throw new Exception('Permission denied');
            }

            $security_ip->delete();
            $this->flashSession->success('IP Deleted from the list');
        } catch (Exception $e) {
            $this->flashSession->error($e->getMessage());
        }

        $this->response->redirect('/security');
    }

    public function addipAction()
    {
        try {
            if (!$this->request->hasPost('add-ip')) {
                throw new Exception('There was a problem');
            }

            $ip = new SecurityIp();
            $ip->name = $this->request->getPost('ip-name');
            $ip->user_id = $this->session->get('user_id');
            $ip->ip = $this->request->getPost('ip-address');
            $success = $ip->save();

            if (!$success) {
                foreach ($ip->getMessages() as $message) {
                    echo $message . PHP_EOL;
                }
                die();
            }

            $this->flashSession->success('IP successfully added');

        } catch (Exception $e) {
            $this->flashSession->error($e->getMessage());
        }

        $this->response->redirect('/security');
    }
}