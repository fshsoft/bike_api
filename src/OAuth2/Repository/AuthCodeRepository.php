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
        $authCodeRedisDao = $this->container->get('bike.api.redis.dao.auth_code');
        $key = $authCodeRedisDao->getKey($codeId);
        return $authCodeRedisDao->delete($key);
    }

    public function isAuthCodeRevoked($codeId)
    {
        $authCodeRedisDao = $this->container->get('bike.api.redis.dao.auth_code');
        $key = $authCodeRedisDao->getKey($codeId);
        if ($authCodeRedisDao->has($key)) {
            return false;
        }
        return true;
    }
}
