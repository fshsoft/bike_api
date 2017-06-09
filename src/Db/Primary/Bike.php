<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class Bike extends AbstractEntity
{
    const STATUS_CAN_USE = 1;
    const STATUS_UNLOCKING = 2;
    const STATUS_IN_USE = 3;
    const STATUS_LOCKING = 4;
    const STATUS_CHECKOUTING = 5;
    const STATUS_BROKEN = 6;

    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'elock_id' => 0,
        'user_id' => 0,
        'status' => self::STATUS_CAN_USE,
        'lat' => '',
        'lng' => '',
        'create_time' => null,
    );
}
