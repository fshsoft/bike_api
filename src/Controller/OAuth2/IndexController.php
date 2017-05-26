<?php

namespace Bike\Api\Controller\OAuth2;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;
use Bike\Api\OAuth2\Repository\ClientRepository;
use Bike\Api\OAuth2\Repository\ScopeRepository;
use Bike\Api\OAuth2\Repository\UserRepository;
use Bike\Api\OAuth2\Repository\AccessTokenRepository;
use Bike\Api\OAuth2\Repository\RefreshTokenRepository;
use Bike\Api\OAuth2\Repository\AuthCodeRepository;

class IndexController extends AbstractController
{
    public function accessTokenAction(Request $request, Response $response)
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

        return $server->respondToAccessTokenRequest($request, $response);
    }

    public function authorizeAction(Request $request, Response $response)
    {
        echo 'authorize';
    }
}
