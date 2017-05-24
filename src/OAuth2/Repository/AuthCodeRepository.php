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

    }

    public function isAuthCodeRevoked($codeId)
    {

    }
}

