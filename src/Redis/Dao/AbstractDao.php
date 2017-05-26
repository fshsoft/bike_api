<?php

namespace Bike\Api\Redis\Dao;

use Bike\Api\Redis\ConnectionAwareTrait;

abstract class AbstractDao
{
    use ConnectionAwareTrait;

    public function delete($key)
    {
        return $this->conn->del($key);
    }

    public function has($key)
    {
        return $this->conn->exists($key);
    }
}
