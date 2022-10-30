<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class GeAuthUsers extends Model
{
    public $id;
    protected $ge_auth_user_group;
    public $user_group;
    public $email;
    public $password;
    public $username;
    public $phone;
    public $reqistered_at;

    public function initialize()
    {
        $this->setSource('ge_auth_users');

        $this->addBehavior(
            new Timestampable(
                [
                    'beforeCreate' => [
                        'field' => 'registered_at',
                        'format' => 'Y-m-d H:i:s'
                    ]
                ]
            )
        );
    }

    public function afterFetch()
    {
        $this->user_group = GeAuthUserGroups::findFirst([
            'conditions' => 'id = :ge_auth_user_group_id:',
            'bind' => [
                'ge_auth_user_group_id' => $this->ge_auth_user_group,
            ],
        ]);
    }

    public function setUserGroupId($user_group_id)
    {
        $this->ge_auth_user_group = $user_group_id;
    }
}