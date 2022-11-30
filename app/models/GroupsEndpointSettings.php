<?php

use Phalcon\Mvc\Model;

class GroupsEndpointSettings extends Model
{
    public $id;
    public $ge_id;
    public $e_id;
    public $group_id;

    public $get_allow;
    public $post_allow;
    public $put_allow;
    public $delete_allow;

    public function initialize()
    {
        $this->setSource('auth_groups2endpoints');
    }

    public static function getGlobalEndpointGroup($ge_id, $group_id = -1)
    {
        return GroupsEndpointSettings::findFirst([
            'conditions' => 'ge_id = :ge_id: AND group_id = :group_id:',
            'bind' => [
                'ge_id' => $ge_id,
                'group_id' => $group_id,
            ],
        ]);
    }

    public static function getEndpointGroup($e_id, $group_id)
    {
        return GroupsEndpointSettings::findFirst([
            'conditions' => 'e_id = :e_id: AND group_id = :group_id:',
            'bind' => [
                'e_id' => $e_id,
                'group_id' => $group_id,
            ],
        ]);
    }
}