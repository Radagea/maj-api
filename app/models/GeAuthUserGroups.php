<?php

use Phalcon\Mvc\Model;

class GeAuthUserGroups extends Model
{
    public $id;
    public $unique_identifier;
    protected $ge_id;
    public $global_endpoint;
    protected $user_id;
    public $user;
    public $name;
    public $is_default;
    public $count;

    public function initialize()
    {
        $this->setSource('ge_auth_user_groups');
    }

    public function afterFetch()
    {
        $this->global_endpoint = GlobalEndpoints::findFirst([
            'conditions' => 'id = :ge_id:',
            'bind' => [
                'ge_id' => $this->ge_id,
            ]
        ]);

        $this->user = Users::findFirst([
            'conditions' => 'id = :user_id:',
            'bind' => [
                'user_id' => $this->user_id,
            ]
        ]);
    }

    public function setGeId($ge_id)
    {
        $this->ge_id = $ge_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public static function getFromUserId($user_id)
    {
        return GeAuthUserGroups::find([
            'conditions' => 'user_id = :user_id:',
            'bind' => [
                'user_id' => $user_id,
            ],
        ]);
    }

    public static function getFirstFromUserIdAndUniqId($user_id, $uniq_id)
    {
        return GeAuthUserGroups::findFirst([
            'conditions' => 'user_id = :user_id: AND unique_identifier = :uniq_id:',
            'bind' => [
                'user_id' => $user_id,
                'uniq_id' => $uniq_id,
            ]
        ]);
    }

    public static function createUniqId($username)
    {
        $additional = '';
        for ($i = 0; $i < 3; $i++) {
            $num = rand(0,9);
            $additional .= (string)$num;
        }

        return strtoupper($username[rand(0, strlen($username)-1)] . $username[rand(0, strlen($username)-1)] . '-' . $additional . '-' . $username[rand(0, strlen($username)-1)] . $username[rand(0, strlen($username)-1)]);
    }

}