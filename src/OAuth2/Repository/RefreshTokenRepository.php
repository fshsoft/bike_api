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

    }

    public function revokeRefreshToken($tokenId)
    {

    }

    public function isRefreshTokenRevoked($tokenId)
    {

    }
}
