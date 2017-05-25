<?php

namespace Bike\Api\Redis;

trait ConnectionAwareTrait
{
    protected $conn;

    public function setConn(Connection $conn)
    {
        $this->conn = $conn;
        return $this;
    }
}
