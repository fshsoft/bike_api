<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class Elock extends AbstractEntity
{
    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'mac' => null,
        'bike_id' => 0,
        'create_time' => null,
    );
}
