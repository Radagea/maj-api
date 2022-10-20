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
}