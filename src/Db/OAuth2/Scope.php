<?php

namespace Bike\Api\Db\OAuth2;

use Bike\Api\Db\AbstractEntity;

class Scope extends AbstractEntity
{
    protected static $pk = 'scope';

    protected static $cols = array(
        'scope' => null,
        'intro' => null,
    );
}
