<?php

use Phalcon\Mvc\Model;

class GlobalEndpointType extends Model
{
    public $id;
    public $name;
    public $endpoint_uri;

    public function initialize() {
        $this->setSource('global_endpoint_types');
    }
}
