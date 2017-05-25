<?php

namespace Bike\Api\Db\OAuth2;

use Bike\Api\Db\AbstractEntity;

class AuthCode extends AbstractEntity
{
    protected static $pk = 'auth_code';

    protected static $cols = array(
        'auth_code' => null,
        'client_id' => null,
        'user_id' => 0,
        'scopes' => '',
        'redirect_uri' => null,
        'expire_time' => null,
        'create_time' => null,
    );
}
