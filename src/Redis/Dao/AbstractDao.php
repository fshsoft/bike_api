<?php

namespace Bike\Api\Redis\Dao;

use Bike\Api\Redis\ConnectionAwareTrait;

abstract class AbstractDao
{
    use ConnectionAwareTrait;

    public function delete($key)
    {
        $key = $this->getKey();
        return $this->conn->del($key);
    }

    public function has($key)
    {
        $key = $this->getKey($key);
        return $this->conn->exists($key);
    }

    abstract protected function getKey($sharding = null);
}
