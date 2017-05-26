<?php

namespace Bike\Api\Redis\Dao;

class RefreshTokenDao extends AbstractDao
{
    protected $fields = [
        'refresh_token' => null,
        'access_token' => null,
        'client_id' => null,
        'user_id' => null,
        'scopes' => null,
        'expire_time' => null,
        'create_time' => null,
    ];
}
