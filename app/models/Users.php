<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $username;
    public $email;
    public $unique_uri;
    public $password;


    public function afterCreate()
    {
        GlobalEndpoints::generateGlobalEndpoints($this->id);
    }

    public function createUri()
    {
        $additional_id = '';

        for ($i = 0; $i < 4; $i++) {
            $num = rand(0,9);
            $additional_id .= (string)$num;
        }

        $this->unique_uri = strtolower($this->username) . '-' . $additional_id;
    }

    public static function getUserById($user_id)
    {
        return Users::findFirst(
            [
                'conditions' => 'id = :user_id:',
                'bind' => [
                    'user_id' => $user_id
                ],
            ]
        );
    }
}