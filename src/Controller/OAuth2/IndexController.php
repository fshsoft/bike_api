<?php

namespace Bike\Api\Controller\OAuth2;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function accessTokenAction(Request $request, Response $response)
    {
        try {
            $oauth2Service = $this->container->get('bike.api.service.oauth2');
            $grantType = $request->getParsedBodyParam('grant_type');
            $server = $oauth2Service->createAuthorizationServer($grantType);
            return $server->respondToAccessTokenRequest($request, $response);
        } catch (\Exception $e) {
            return $this->jsonError($response, $e, '获取access_token失败');
        }
    }

    public function authorizeAction(Request $request, Response $response)
    {
        echo 'authorize';
    }
}
