<?php

namespace Bike\Api\Db\OAuth2;

use Bike\Api\Db\AbstractEntity;

class RefreshToken extends AbstractEntity
{
    protected static $pk = 'refresh_token';

    protected static $cols = array(
        'refresh_token' => null,
        'client_id' => null,
        'user_id' => null,
        'scopes' => null,
        'access_token' => null,
        'expire_time' => null,
        'create_time' => null,
    );
}
