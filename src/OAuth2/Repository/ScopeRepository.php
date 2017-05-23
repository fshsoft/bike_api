<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

use Bike\Api\Service\AbstractService;

class ScopeRepository extends AbstractService implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($identifier)
    {

    }

    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    )
    {

    }
}
