<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;
use Bike\Api\Util\ArgUtil;
use Bike\Api\OAuth2\Repository\ClientRepository;
use Bike\Api\OAuth2\Repository\ScopeRepository;
use Bike\Api\OAuth2\Repository\AuthCodeRepository;
use Bike\Api\OAuth2\Repository\UserRepository;
use Bike\Api\OAuth2\Repository\AccessTokenRepository;
use Bike\Api\OAuth2\Repository\RefreshTokenRepository;

class OAuth2Service extends AbstractService
{
    public function createAuthorizationServer($grantType)
    {
        switch ($grantType) {
            case 'password':
                return $this->createPasswordGrantTypeAuthorizationServer();
            case 'client_credentials':
                return $this->createClientCredentialsGrantTypeAuthorizationServer();
            case 'refresh_token':
                return $this->createRefreshTokenGrantTypeAuthorizationServer();
            default:
                throw new LogicException('不支持的grant type');
        }
    }

    public function createResourceServer()
    {
        $accessTokenRepository = new AccessTokenRepository($this->container);
        $publicKeyPath = $this->container->get('settings')['oauth2']['public_key'];
        $server = new \League\OAuth2\Server\ResourceServer(
            $accessTokenRepository,
            $publicKeyPath
        );
        return $server;
    }

    protected function createPasswordGrantTypeAuthorizationServer()
    {
        $clientRepository = new ClientRepository($this->container);
        $scopeRepository = new ScopeRepository($this->container);
        $accessTokenRepository = new AccessTokenRepository($this->container);
        $userRepository = new UserRepository($this->container);
        $refreshTokenRepository = new RefreshTokenRepository($this->container); 

        $privateKey = $this->container->get('settings')['oauth2']['private_key'];
        $publicKey = $this->container->get('settings')['oauth2']['public_key'];

        $server = new \League\OAuth2\Server\AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $publicKey
        );

        $grant = new \League\OAuth2\Server\Grant\PasswordGrant(
            $userRepository,
            $refreshTokenRepository
        );

        $refreshTokenTtl = $this->container->get('settings')['oauth2']['refresh_token_ttl'];
        $grant->setRefreshTokenTTL(new \DateInterval('PT' . $refreshTokenTtl . 'S'));

        $accessTokenTtl = $this->container->get('settings')['oauth2']['access_token_ttl'];
        $server->enableGrantType(
            $grant,
            new \DateInterval('PT' . $accessTokenTtl . 'S')
        );
        return $server;
    }

    protected function createClientCredentialsGrantTypeAuthorizationServer()
    {
        $clientRepository = new ClientRepository($this->container);
        $scopeRepository = new ScopeRepository($this->container);
        $accessTokenRepository = new AccessTokenRepository($this->container);

        $privateKey = $this->container->get('settings')['oauth2']['private_key'];
        $publicKey = $this->container->get('settings')['oauth2']['public_key'];

        $server = new \League\OAuth2\Server\AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $publicKey
        );

        $accessTokenTtl = $this->container->get('settings')['oauth2']['access_token_ttl'];
        $server->enableGrantType(
            new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
            new \DateInterval('PT' . $accessTokenTtl . 'S')
        );
        return $server;
    }

    protected function createRefreshTokenGrantTypeAuthorizationServer()
    {
        $clientRepository = new ClientRepository($this->container);
        $accessTokenRepository = new AccessTokenRepository($this->container);
        $scopeRepository = new ScopeRepository($this->container);
        $refreshTokenRepository = new RefreshTokenRepository($this->container);

        $privateKey = $this->container->get('settings')['oauth2']['private_key'];
        $publicKey = $this->container->get('settings')['oauth2']['public_key'];

        $server = new \League\OAuth2\Server\AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $publicKey
        );

        $refreshTokenTtl = $this->container->get('settings')['oauth2']['refresh_token_ttl'];
        $accessTokenTtl = $this->container->get('settings')['oauth2']['access_token_ttl'];
        $grant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($refreshTokenRepository);
        $grant->setRefreshTokenTTL(new \DateInterval('PT' . $refreshTokenTtl . 'S'));

        $server->enableGrantType(
            $grant,
            new \DateInterval('PT' . $accessTokenTtl . 'S')
        );
        return $server;
    }

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
        $key = $this->getRequestCacheKey('client.id', $id);
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
        $key = $this->getRequestCacheKey('scope.id', $id);
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
