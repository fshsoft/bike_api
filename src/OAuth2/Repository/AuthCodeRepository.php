<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;

use Bike\Api\Service\AbstractService;

class AuthCodeRepository extends AbstractService implements AuthCodeRepositoryInterface
{
    public function getNewAuthCode()
    {

    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {

    }

    public function revokeAuthCode($codeId)
    {

    }

    public function isAuthCodeRevoked($codeId)
    {

    }

    protected function getAuthCodeDao()
    {
        return $this->container->get('bike.api.dao.oauth2.auth_code');
    }
}

