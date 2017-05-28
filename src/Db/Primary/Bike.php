<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class Bike extends AbstractEntity
{
    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'elock_id' => 0,
        'lat' => '',
        'lng' => '',
        'create_time' => null,
    );
}
