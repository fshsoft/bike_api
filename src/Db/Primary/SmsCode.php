<?php

namespace Bike\Api\Db\Primary;

use Bike\Api\Db\AbstractEntity;

class SmsCode extends AbstractEntity
{
    const TYPE_LOGIN = 1;

    const STATUS_NOT_USED = 0;
    const STATUS_USED = 1;

    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'mobile' => null,
        'code' => null,
        'user_id' => null,
        'type' => null,
        'status' => null,
        'expire_time' => null,
        'create_time' => null,
    );
 
