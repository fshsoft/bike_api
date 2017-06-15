<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class Option extends AbstractEntity
{
    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'name' => null,
        'val' => null,
        'order_no' => 0,
        'autoload' => 1,
    );
}
