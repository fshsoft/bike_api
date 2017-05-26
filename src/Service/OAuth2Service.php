<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;
use Bike\Api\Util\ArgUtil;

class OAuth2Service extends AbstractService
{
    public function hashClientPassword($password)
    {
        $options = [
            'cost' => 10,
        ];

        return  password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function verifyClientPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function getClient($id)
    {
        $key = 'client.' . $id;
        $client = $this->getRequestCache($key);
        if (!$client) {
            $clientDao = $this->getClientDao();
            $client = $clientDao->find($id);
            if ($client) {
                $this->setRequestCache($key, $client);
            }
        }
        return $client;
    }

    public function getScope($id)
    {
        $key = 'scope.' . $id;
        $scope = $this->getRequestCache($key);
        if (!$scope) {
            $scopeDao = $this->getScopeDao();
            $scope = $scopeDao->find($id);
            if ($scope) {
                $this->setRequestCache($key, $scope);
            }
        }
        return $scope;
    }

    protected function getClientDao()
    {
        return $this->container->get('bike.api.dao.oauth2.client');
    }

    protected function getScopeDao()
    {
        return $this->container->get('bike.api.dao.oauth2.scope');
    }
}
