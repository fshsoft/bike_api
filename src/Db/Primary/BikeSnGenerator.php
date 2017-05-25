<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class BikeSnGenerator extends AbstractEntity
{
    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'stub' => 'a',
    );
}
