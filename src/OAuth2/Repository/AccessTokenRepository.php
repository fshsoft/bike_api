<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;

use Bike\Api\OAuth2\Entity\AccessTokenEntity;

class AccessTokenRepository extends AbstractRepository implements AccessTokenRepositoryInterface
{
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        return $accessToken;
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $ttl = $this->container->get('settings')['oauth2']['access_token_ttl'];
        $tokenId = $accessTokenEntity->getIdentifier();
        $expireTime = $accessTokenEntity->getExpiryDateTime()->getTimestamp();
        $createTime = $expireTime - $ttl;
        $value = array(
            'access_token' => $tokenId,
            'client_id' => $accessTokenEntity->getClient()->getIdentifier(),
            'user_id' => $accessTokenEntity->getUserIdentifier(),
            'expire_time' => $expireTime,
            'create_time' => $createTime,
        );
        $scopeEntityList = $accessTokenEntity->getScopes();
        $scopes = array();
        foreach ($scopeEntityList as $v) {
            $scopes[] = $v->getIdentifier();
        }
        $value['scopes'] = implode(' ', $scopes);
        $accessTokenDao = $this->container->get('bike.api.redis.dao.access_token');
        $accessTokenDao->save($tokenId, $value, $expireTime);
    }

    public function revokeAccessToken($tokenId)
    {
        $accessTokenDao = $this->container->get('bike.api.redis.dao.access_token');
        return $accessTokenDao->delete($tokenId);
    }

    public function isAccessTokenRevoked($tokenId)
    {
        $accessTokenDao = $this->container->get('bike.api.redis.dao.access_token');
        if ($accessTokenDao->has($tokenId)) {
            return false;
        }
        return true;
    }
}
