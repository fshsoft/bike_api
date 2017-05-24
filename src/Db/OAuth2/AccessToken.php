<?php

namespace Bike\Api\Db\OAuth2;

use Bike\Api\Db\AbstractEntity;

class AccessToken extends AbstractEntity
{
    protected static $pk = 'access_token';

    protected static $cols = array(
        'access_token' => null,
        'client_id' => null,
        'user_id' => 0,
        'scopes' => '',
        'expire_time' => null,
        'create_time' => null,
    );
}
