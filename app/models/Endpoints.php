<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Endpoints extends Model
{
    public $id;
    public $user_id;
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

    public static function normalizeURI($uri,$user_id)
    {
        $endpoint_uri = $uri;
        $endpoint_uri = strtolower($endpoint_uri);
        $endpoint_uri = str_replace(' ', '-', $endpoint_uri);
        $endpoint_uri = str_replace(['\'', '"', ',' , ';', '<', '>', '.'], '', $endpoint_uri);
        if ($count = self::countUriForUser($endpoint_uri, $user_id) > 0) {
            $endpoint_uri .= '-'.$count;
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
}