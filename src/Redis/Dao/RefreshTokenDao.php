<?php

namespace Bike\Api\Redis\Dao;

class RefreshTokenDao extends AbstractHashDao
{
    protected $fields = [
        'refresh_token' => null,
        'access_token' => null,
        'expire_time' => null,
        'create_time' => null,
    ];
}
