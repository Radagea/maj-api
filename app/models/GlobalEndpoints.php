<?php

use Phalcon\Mvc\Model;

class GlobalEndpoints extends Model
{
    public $id;
    protected $user_id;
    public $user;
    public $endpoint_name;
    public $endpoint_uri;
    public $enabled;
    public $auth_req;
    public $endpoint_type;

    public $group_settings;

    public function initialize() {
        $this->setSource('user_global_endpoint');
    }

    public function afterFetch()
    {
        $this->user = Users::findFirst([
            'conditions' => 'id = :user_id:',
            'bind' => [
                'user_id' => $this->user_id,
            ]
        ]);
        $group_settings = GroupsEndpointSettings::find(['conditions' => 'ge_id = :ge_id:', 'bind' => ['ge_id' => $this->id]]);
        $this->group_settings = [];

        if ($group_settings) {
            foreach ($group_settings as $group_setting) {
                $this->group_settings[] = $group_setting->group_id;
            }
        }
    }

    public static function getGlobalEndpointsByUserId($user_id)
    {
        return GlobalEndpoints::find(
            [
                'conditions' => 'user_id = :user_id:',
                'bind' => [
                    'user_id' => $user_id
                ],
            ]
        );
    }

    public static function hasPermission($endpoint_id, $user_id)
    {
        return GlobalEndpoints::count(
            [
                'conditions' => 'id = :endpoint_id: AND user_id = :user_id:',
                'bind' => [
                    'endpoint_id' => $endpoint_id,
                    'user_id' => $user_id,
                ],
            ]
        );
    }

    public static function generateGlobalEndpoints($user_id,$user_name)
    {
        $global_endpoint_types = GlobalEndpointType::find();
        foreach ($global_endpoint_types as $global_endpoint_type) {
            $global_endpoint = new GlobalEndpoints();
            $global_endpoint->user_id = $user_id;
            $global_endpoint->endpoint_name = $global_endpoint_type->name;
            $global_endpoint->endpoint_type = $global_endpoint_type->id;
            $global_endpoint->endpoint_uri = $global_endpoint_type->endpoint_uri;
            $global_endpoint->save();
            if ($global_endpoint_type->id == 2) {
                $user_group = new GeAuthUserGroups();
                $user_group->setUserId($global_endpoint->user_id);
                $user_group->setGeId($global_endpoint->id);
                $user_group->name = 'Default user group';
                $user_group->is_default = 1;
                $user_group->is_admin = 0;
                $user_group->unique_identifier = GeAuthUserGroups::createUniqId(
                    $user_name,
                    $global_endpoint->user_id
                );
                $user_group->save();

                $user_group = new GeAuthUserGroups();
                $user_group->setUserId($global_endpoint->user_id);
                $user_group->setGeId($global_endpoint->id);
                $user_group->name = 'Admin';
                $user_group->is_admin = 1;
                $user_group->unique_identifier = GeAuthUserGroups::createUniqId(
                    $user_name,
                    $global_endpoint->user_id
                );
                $user_group->save();
            }
        }
    }

    public static function getEndpointByUserAndEndpointUri($user_id,$endpoint_uri)
    {
        return GlobalEndpoints::findFirst(
            [
                'conditions' => 'user_id = :user_id: AND endpoint_uri = :endpoint_uri: AND enabled = 1',
                'bind' => [
                    'user_id' => $user_id,
                    'endpoint_uri' => $endpoint_uri,
                ],
            ]
        );
    }
}
