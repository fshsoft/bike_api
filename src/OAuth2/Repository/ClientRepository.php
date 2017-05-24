<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

use Bike\Api\OAuth2\Entity\ClientEntity;

class ClientRepository extends AbstractRepository implements ClientRepositoryInterface
{
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $oauth2Service = $this->container->get('bike.api.service.oauth2');
        $client = $oauth2Service->getClient($clientIdentifier);
        if (!$client) {
            return;
        }

        if (
            $mustValidateSecret === true
            && $client->getIsConfidential() === true
            && $oauth2Service->verifyClientPassword($clientSecret, $client->getSecret()) === false
        ) {
            return;
        }
        $clientEntity = new ClientEntity();
        $clientEntity
            ->setIdentifier($client->getId())
            ->setName($client->getName())
            ->setRequestUri($client->getRedirectUri());
        return $clientEntity;
    }
}

