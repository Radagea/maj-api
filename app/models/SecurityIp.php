<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class SecurityIp extends Model
{
    public $id;
    public $user_id;
    public $name;
    public $ip;
    public $add_date;

    public function initialize()
    {
        $this->setSource('security_ips');
    }

    public static function getIpsAsArray($user_id) : Array
    {
        $ips = SecurityIp::find([
           'conditions' => 'user_id = :user_id:',
           'bind' => ['user_id' => $user_id],
        ]);

        $ip_arrs = [];
        foreach ($ips as $ip) {
            $ip_arrs[] = $ip->ip;
        }

        return $ip_arrs;
    }
}
