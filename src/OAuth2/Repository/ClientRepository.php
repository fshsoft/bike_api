<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

use Bike\Api\Service\AbstractService;
use Bike\Api\OAuth2\Entity\ClientEntity;

class ClientRepository extends AbstractService implements ClientRepositoryInterface
{
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $clientDao = $this->getClientDao();
        $client = $clientDao->find($clientIdentifier);
        if (!$client) {
            return;
        }

        if (
            $mustValidateSecret === true
            && $client->getIsConfidential() === true
            && password_verify($clientSecret, $client->getSecret()) === false
        ) {
            return;
        }
        $clientEntity = new ClientEntity($client);
        return $clientEntity;
    }

    protected function getClientDao()
    {
        return $this->container->get('bike.api.dao.oauth2.client');
    }
}

