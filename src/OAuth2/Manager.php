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
        $grantType = ArgUtil::getArg($data, 'grant_type');
        switch ($grantType) {
            case 'password':
                return $this->createPasswordGrantAuthorizationServer($data);
            case 'client_credentials':
                return $this->createClientCredentialsGrantAuthorizationServer($data);
            case 'refresh_token':
                return $this->createRefreshTokenGrantAuthorizationServer($data);
        }
    }

    protected function createPasswordGrantAuthorizationServer(array $data)
    {
        $data = ArgUtil::getArgs($data, array(
            'client_id',
            'client_secret',
            'scope',
            'username',
            'password',
        ));
    }

    protected function createClientCredentialsGrantAuthorizationServer(array $data)
    {

    }

    protected function createRefreshTokenGrantAuthorizationServer(array $data)
    {

    }
}
