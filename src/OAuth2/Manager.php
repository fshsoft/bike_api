<?php

namespace Bike\Api\OAuth2;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use Bike\Api\Util\ArgUtil;
use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;

class Manager
{
    use ContainerAwareTrait;

    public function createAuthorizationServer(array $data)
    {
        $data = ArgUtil::getArgs($data, array(

        ));
    }
}
