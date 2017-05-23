<?php

namespace Bike\Api\OAuth2;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Manager
{
    use ContainerAwareTrait;

    protected $clientRepository;

    protected $scopeRepository;

    protected $accessTokenRepository;

    protected $userRepository;

    protected $refreshTokenRepository;

    public function getAuthorizationServer()
    {
        $clientRepository = $this->getClientRepository();
        $scopeRepository = $this->getScopeRepository();
        $accessTokenRepository = $this->getAccessTokenRepository();
        $userRepository = $this->getUserRepository();
        $refreshTokenRepository = $this->getRefreshTokenRepository();

        $privateKey = $this->container->getParameter('bike.api.params.oauth2.private_key');
        $publicKey = $this->container->getParameter('bike.api.params.oauth2.public_key');

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
        $grant->setRefreshTokenTTL(new \DateInterval('P1M')); 

        $server->enableGrantType(
            $grant,
            new \DateInterval('PT1H')
        );
        return $server;
    }

    protected function getClientRepository()
    {
        if (!$this->clientRepository) {
            $this->clientRepository = new Repository\ClientRepository();
            $this->clientRepository->setContainer($this->container);
        }
        return $this->clientRepository;
    }

    protected function getAccessTokenRepository()
    {
        if (!$this->accessTokenRepository) {
            $this->accessTokenRepository = new Repository\AccessTokenRepository();
            $this->accessTokenRepository->setContainer($this->container);
        }
        return $this->accessTokenRepository;
    }

    protected function getRefreshTokenRepository()
    {
        if (!$this->refreshTokenRepository) {
            $this->refreshTokenRepository = new Repository\RefreshTokenRepository();
            $this->refreshTokenRepository->setContainer($this->container);
        }
        return $this->refreshTokenRepository;
    }

    protected function getUserRepository()
    {
        if (!$this->userRepository) {
            $this->userRepository = new Repository\UserRepository();
            $this->userRepository->setContainer($this->container);
        }
        return $this->userRepository;
    }

    protected function getScopeRepository()
    {
        if (!$this->scopeRepository) {
            $this->scopeRepository = new Repository\ScopeRepository();
            $this->scopeRepository->setContainer($this->container);
        }
        return $this->scopeRepository;
    }
}
