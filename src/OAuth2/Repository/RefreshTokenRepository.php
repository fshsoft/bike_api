<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

use Bike\Api\OAuth2\Entity\RefreshTokenEntity;

class RefreshTokenRepository extends AbstractRepository implements RefreshTokenRepositoryInterface
{
    public function getNewRefreshToken()
    {
        $refreshTokenEntity = new RefreshTokenEntity();
        return $refreshTokenEntity;
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $ttl = $this->container->get('settings')['oauth2']['refresh_token_ttl'];
        $tokenId = $refreshTokenEntity->getIdentifier();
        $expireTime = $refreshTokenEntity->getExpiryDateTime()->getTimestamp();
        $createTime = $expireTime - $ttl;
        $value = array(
            'refresh_token' => $tokenId,
            'access_token' => $refreshTokenEntity->getAccessToken()->getIdentifier(),
            'expire_time' => $expireTime,
            'create_time' => $createTime,
        );
        $refreshTokenRedisDao = $this->container->get('bike.api.redis.dao.refresh_token');
        $key = $refreshTokenRedisDao->getKey($tokenId);
        $refreshTokenRedisDao->save($key, $value, $expireTime);
    }

    public function revokeRefreshToken($tokenId)
    {
        $refreshTokenRedisDao = $this->container->get('bike.api.redis.dao.refresh_token');
        $key = $refreshTokenRedisDao->getKey($tokenId);
        return $refreshTokenRedisDao->delete($key);
    }

    public function isRefreshTokenRevoked($tokenId)
    {
        $refreshTokenRedisDao = $this->container->get('bike.api.redis.dao.refresh_token');
        $key = $refreshTokenRedisDao->getKey($tokenId);
        if ($refreshTokenRedisDao->has($key)) {
            return false;
        }
        return true;
    }
}
