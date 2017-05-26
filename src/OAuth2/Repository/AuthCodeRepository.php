<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;

class AuthCodeRepository extends AbstractRepository implements AuthCodeRepositoryInterface
{
    public function getNewAuthCode()
    {

    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {

    }

    public function revokeAuthCode($codeId)
    {
        $authCodeDao = $this->container->get('bike.api.redis.dao.auth_code');
        return $authCodeDao->delete($codeId);
    }

    public function isAuthCodeRevoked($codeId)
    {
        $authCodeDao = $this->container->get('bike.api.redis.dao.auth_code');
        if ($authCodeDao->has($codeId)) {
            return false;
        }
        return true;
    }
}

