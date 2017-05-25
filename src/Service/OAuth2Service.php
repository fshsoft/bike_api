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

    public function getAccessToken($id)
    {
        $key = 'access_token.' . $id;
        $accessToken = $this->getRequestCache($key);
        if (!$accessToken) {
            $accessTokenDao = $this->getAccessTokenDao();
            $accessToken = $accessTokenDao->find($id);
            if (!$accessToken) {
                $this->setRequestCache($key, $accessToken);
            }
        }
        return $accessToken;
    }

    public function deleteAccessToken($id)
    {
        $accessTokenDao = $this->getAccessTokenDao();
        $accessTokenDao->delete($id);
        $key = 'access_token.' . $id;
        $this->unsetRequestCache($key);
    }

    public function getAuthCode($id)
    {
        $key = 'auth_code.' . $id;
        $authCode = $this->getRequestCache($key);
        if (!$authCode) {
            $authCodeDao = $this->getAuthCodeDao();
            $authCode = $authCodeDao->find($id);
            if ($authCode) {
                $this->setRequestCache($key, $authCode);
            }
        }
        return $authCode;
    }

    public function deleteAuthCode($id)
    {
        $authCodeDao = $this->getAuthCodeDao();
        $authCodeDao->delete($id);
        $key = 'auth_code.' . $id;
        $this->unsetRequestCache($key);
    }

    public function getRefreshToken($id)
    {
        $key = 'refresh_token.' . $id;
        $refreshToken = $this->getRequestCache($key);
        if (!$refreshToken) {
            $refreshTokenDao = $this->getRefreshTokenDao();
            $refreshToken = $refreshTokenDao->find($id);
            if ($refreshToken) {
                $this->setRequestCache($key, $refreshToken);
            }
        }
        return $refreshToken;
    }

    public function deleteRefreshToken($id)
    {
        $refreshTokenDao = $this->getRefreshTokenDao();
        $refreshTokenDao->delete($id);
        $key = 'refresh.token.' . $id;
        $this->unsetRequestCache($key);
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

    protected function getAccessTokenDao()
    {
        return $this->container->get('bike.api.dao.oauth2.access_token');
    }

    protected function getRefreshTokenDao()
    {
        return $this->container->get('bike.api.dao.oauth2.refresh_token');
    }

    protected function getAuthCodeDao()
    {
        return $this->container->get('bike.api.dao.oauth2.auth_code');
    }

    protected function getScopeDao()
    {
        return $this->container->get('bike.api.dao.oauth2.scope');
    }
}
