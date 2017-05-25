<?php

namespace Bike\Api\Db\OAuth2;

use Bike\Api\Db\AbstractEntity;

class Client extends AbstractEntity
{
    protected static $pk = 'id';

    protected static $cols = array(
        'id' => null,
        'secret' => null,
        'name' => null,
        'redirect_uri' => null,
        'grant_types' => null,
        'scopes' => '',
        'is_confidential' => 1,
        'create_time' => 0,
    );
}
