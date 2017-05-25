<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class Bike extends AbstractEntity
{
    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'sn' => null,
        'elock_sn' => '',
        'client_id' => 0,
        'agent_id' => 0,
        'create_time' => null,
    );
}
