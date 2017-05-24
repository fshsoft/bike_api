<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;

use Bike\Api\OAuth2\Entity\AccessTokenEntity;
use Bike\Api\Db\OAuth2\AccessToken;

class AccessTokenRepository extends AbstractRepository implements AccessTokenRepositoryInterface
{
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        return $accessToken;
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        return;
        $time = time();
        $accessTokenDao = $this->container->get('bike.api.dao.oauth2.access_token');
        $accessToken = new AccessToken();
        $accessToken
            ->setAccessToken($accessTokenEntity->getIdentifier())
            ->setClientId($accessTokenEntity->getClient()->getIdentifier())
            ->setUserId($accessTokenEntity->getUserIdentifier())
            ->setExpireTime($accessTokenEntity->getExpiryDateTime()->getTimestamp())
            ->setCreateTime($time);
        $scopeEntityList = $accessTokenEntity->getScopes();
        $scopes = array();
        foreach ($scopeEntityList as $v) {
            $scopes[] = $v->getIdentifier();
        }
        $accessToken->setScopes(implode(' ', $scopes));
        $accessTokenDao->create($accessToken);
    }

    public function revokeAccessToken($tokenId)
    {
        $oauth2Service = $this->container->get('bike.api.service.oauth2');
        $oauth2Service->deleteAccessToken($tokenId);
        return $tokenId;
    }

    public function isAccessTokenRevoked($tokenId)
    {
        $oauth2Service = $this->container->get('bike.api.service.oauth2');
        $accessToken = $oauth2Service->getAccessToken($tokenId);
        if ($accessToken) {
            return false;
        }
        return true;
    }
}

