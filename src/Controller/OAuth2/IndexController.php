<?php

namespace Bike\Api\Controller\OAuth2;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function accessTokenAction(Request $request, Response $response)
    {
        echo 'access_token';
    }

    public function authorizeAction(Request $request, Response $response)
    {
        echo 'authorize';
    }
}
