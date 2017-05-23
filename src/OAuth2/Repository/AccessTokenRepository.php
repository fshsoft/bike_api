<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;

use Bike\Api\Service\AbstractService;
use Bike\Api\OAuth2\Entity\AccessTokenEntity;
use Bike\Api\Db\OAuth2\AccessToken;

class AccessTokenRepository extends AbstractService implements AccessTokenRepositoryInterface
{
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        return $accessToken;
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $accessTokenDao = $this->getAccessTokenDao();
        $accessToken = new AccessToken();
        $accessToken
            ->setAccessToken($accessTokenEntity->getIdentifier());
    }

    public function revokeAccessToken($tokenId)
    {
        $accessTokenDao = $this->getAccessTokenDao();
        $accessTokenDao->delete($tokenId);
        return $tokenId;
    }

    public function isAccessTokenRevoked($tokenId)
    {
        $accessTokenDao = $this->getAccessTokenDao();
        $accessToken = $accessTokenDao->find($tokenId);
        if ($accessToken) {
            return false;
        }
        return true;
    }

    protected function getAccessTokenDao()
    {
        return $this->container->get('bike.api.dao.oauth2.access_token');
    }
}

