<?php

namespace Bike\Api\Redis\Dao;

class AccessTokenDao extends AbstractHashDao
{
    protected $fields = [
        'access_token' => null,
        'client_id' => null,
        'user_id' => null,
        'scopes' => null,
        'expire_time' => null,
        'create_time' => null,
    ];
}
