<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Endpoints extends Model
{
    public $id;
    public $user_id;
    public $user;
    public $endpoint_name;
    public $endpoint_uri;
    public $enabled;
    public $auth_req;
    public $dataset_id;
    public $description; //MAX 120 Character
    public $created_at;
    public $request_overall;
    public $request_weekly;
    public $request_daily;

    public function initialize()
    {
        $this->setSource('endpoints');
        $this->addBehavior(
            new Timestampable(
                [
                    'beforeCreate' => [
                        'field' => 'created_at',
                        'format' => 'Y-m-d H:i:s'
                    ]
                ]
            )
        );
    }

    public function afterFetch()
    {
        $this->user = Users::findFirst([
            'conditions' => 'id = :user_id:',
            'bind' => [
                'user_id' => $this->user_id,
            ]
        ]);
    }

    public static function normalizeURI($uri,$user_id)
    {
        $endpoint_uri = $uri;
        $endpoint_uri = strtolower($endpoint_uri);
        $endpoint_uri = str_replace(' ', '-', $endpoint_uri);
        $endpoint_uri = str_replace(['\'', '"', ',' , ';', '<', '>', '.'], '', $endpoint_uri);
        $count = 1;
        while($count > 0) {
            $count = self::countUriForUser($endpoint_uri, $user_id);
            if ($count > 0) {
                $modifier = '';
                for ($i = 0; $i < 4; $i++) {
                    $num = rand(0,9);
                    $modifier .= (string)$num;
                }
                $endpoint_uri .= '-'.$modifier;
            }
        }

        return $endpoint_uri;
    }

    public static function countUriForUser($uri, $user_id)
    {
        return Endpoints::count(
            [
                'conditions' => 'user_id = :user_id: AND endpoint_uri = :uri:',
                'bind' => [
                    'user_id' => $user_id,
                    'uri' => $uri,
                ],
            ]
        );
    }

    public static function hasPermission($endpoint_id, $user_id)
    {
        return Endpoints::count(
            [
                'conditions' => 'id = :endpoint_id: AND user_id = :user_id:',
                'bind' => [
                    'endpoint_id' => $endpoint_id,
                    'user_id' => $user_id,
                ],
            ]
        );
    }

    public static function countUserEndpoints($user_id)
    {
        return Endpoints::count(
            [
                'conditions' => 'user_id = :user_id:',
                'bind' => [
                    'user_id' => $user_id,
                ],
            ]
        );
    }

    public static function getEndpointByUserAndEndpointUri($user_id,$endpoint_uri)
    {
        return Endpoints::findFirst(
            [
                'conditions' => 'user_id = :user_id: AND endpoint_uri = :endpoint_uri: AND enabled = 1',
                'bind' => [
                    'user_id' => $user_id,
                    'endpoint_uri' => $endpoint_uri,
                ],
            ]
        );
    }

    public static function getEndpointsByUserId($user_id)
    {
        return Endpoints::find(
            [
                'conditions' => 'user_id = :user_id:',
                'bind' => [
                    'user_id' => $user_id,
                ],
            ]
        );
    }
}
