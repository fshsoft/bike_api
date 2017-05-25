<?php

namespace Bike\Api\Redis\Dao;

class AccessTokenDao extends AbstractDao
{
    protected $fields = [
        'client_id' => null,
        'user_id' => null,
        'scopes' => null,
        'expire_time' => null,
        'create_time' => null,
    ];

    protected function filter(array $data)
    {
        return array_merge($this->fields, array_intersect_key($data, $this->fields));
    }
}
