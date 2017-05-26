<?php

namespace Bike\Api\Redis\Dao;

class AuthCodeDao extends AbstractHashDao
{
    protected $fields = [
        'auth_code' => null,
        'client_id' => null,
        'user_id' => null,
        'scopes' => null,
        'redirect_uri' => null,
        'expire_time' => null,
        'create_time' => null,
    ];

    protected function getKey($sharding = null)
    {
        return 'auth_code_' . $sharding;
    }
}
