<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class User extends AbstractEntity
{
    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'mobile' => null,
        'pwd' => '',
        'name' => '',
        'last_login_ip' => '',
        'last_login_time' => 0,
        'create_time' => null,
    );
}
