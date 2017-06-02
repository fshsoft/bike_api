<?php

namespace Bike\Api\Redis\Dao;

use Bike\Api\Util\ArgUtil;

class SmsCodeDao extends AbstractHashDao
{
    protected $fields = [
        'mobile' => null,
        'type' => null,
        'code' => null,
        'user_id' => null,
        'expire_time' => null,
        'create_time' => null,
    ];

    protected function getKey($sharding = null)
    {
        $sharding = ArgUtil::getArgs((array) $sharding, array(
            'mobile',
            'type',
        ));
        return 'sms_code_' . $sharding['mobile'] . '_' . $sharding['type'];
    }
}
