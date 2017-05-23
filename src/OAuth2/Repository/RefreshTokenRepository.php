<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

use Bike\Api\Service\AbstractService;

class RefreshTokenRepository extends AbstractService implements RefreshTokenRepositoryInterface
{
    public function getNewRefreshToken()
    {

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
