<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

use Bike\Api\OAuth2\Entity\ScopeEntity;

class ScopeRepository extends AbstractRepository implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($identifier)
    {
        $oauth2Service = $this->container->get('bike.api.service.oauth2');
        $scope = $oauth2Service->getScope($identifier);
        if ($scope) {
            $scopeEntity = new ScopeEntity();
            $scopeEntity->setIdentifier($scope->getScope());
            return $scopeEntity;
        }
    }

    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    )
    {
        return $scopes;
    }
}
