<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class Elock extends AbstractEntity
{
    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'sn' => null,
        'bike_sn' => 0,
        'create_time' => null,
    );
}
