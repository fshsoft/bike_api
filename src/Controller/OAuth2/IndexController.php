<?php

namespace Bike\Api\Controller\OAuth2;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

use Bike\Api\Controller\AbstractController;

/**
 * @Route("/oauth2")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/access_token", name="oauth2_access_token")
     */
    public function accessTokenAction(Request $request)
    {
        $clientRepository = $this->get('bike.api.oauth2.repository.client');
        $scopeRepository = $this->get('bike.api.oauth2.repository.scope');
        $accessTokenRepository = $this->get('bike.api.oauth2.repository.access_token');
        $userRepository = $this->get('bike.api.oauth2.repository.user');
        $refreshTokenRepository = $this->get('bike.api.oauth2.repository.refresh_token');

        $privateKey = $this->getParameter('bike.api.params.oauth2.private_key');
        $publicKey = $this->getParameter('bike.api.params.oauth2.public_key');

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

        $grant->setRefreshTokenTTL(new \DateInterval('PT' . $this->getParameter('bike.api.params.oauth2.refresh_token_ttl') . 'S'));

        $server->enableGrantType(
            $grant,
            new \DateInterval('PT' . $this->getParameter('bike.api.params.oauth2.access_token_ttl') . 'S')
        );
        $psr7Factory = new DiactorosFactory();
        $psrRequest = $psr7Factory->createRequest($request);
        $response = new Response();
        $psrResponse = $psr7Factory->createResponse($response);
        return $server->respondToAccessTokenRequest($psrRequest, $psrResponse);
    }

    /**
     * @Route("/authorize", name="oauth2_authorize")
     */
    public function authorizeAction(Request $request)
    {
        return $this->jsonSuccess();
    }

    /**
     * @Route("/test", name="oauth2_test")
     */
    public function testAction(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.bike.lc/oauth2/access_token");
        curl_setopt($ch, CURLOPT_POST, 1);
        $data = array(
            'grant_type' => 'password',
            'client_id' => 'ios',
            'client_secret' => '789789',
            'scope' => 'all',
            'username' => 13862026360,
            'password' => '789789',
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
        echo '<pre>' . print_r(curl_exec($ch), true) . '</pre>';
        curl_close($ch);
        exit;
    }
}
