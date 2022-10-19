<?php

use Phalcon\Mvc\Model;

class GlobalEndpoints extends Model
{
    public $id;
    public $user_id;
    public $endpoint_name;
    public $endpoint_uri;
    public $enabled;
    public $auth_req;
    public $endpoint_type;

    public function initialize() {
        $this->setSource('user_global_endpoint');
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

    public static function generateGlobalEndpoints($user_id)
    {
        $global_endpoint_types = GlobalEndpointType::find();
        foreach ($global_endpoint_types as $global_endpoint_type) {
            $global_endpoint = new GlobalEndpoints();
            $global_endpoint->user_id = $user_id;
            $global_endpoint->endpoint_name = $global_endpoint_type->name;
            $global_endpoint->endpoint_type = $global_endpoint_type->id;
            $global_endpoint->endpoint_uri = $global_endpoint_type->endpoint_uri;
            $global_endpoint->save();
        }
    }
}