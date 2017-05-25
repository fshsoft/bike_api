<?php

namespace Bike\Api\Redis\Dao;

use Bike\Api\Redis\ConnectionAwareTrait;

abstract class AbstractDao
{
    use ConnectionAwareTrait;
}
