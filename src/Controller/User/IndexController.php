<?php

namespace Bike\Api\Controller\User;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function testAction(Request $request, Response $response)
    {
        var_dump($request->getAttribute('oauth_access_token_id'));
        var_dump($request->getAttribute('oauth_client_id'));
        var_dump($request->getAttribute('oauth_user_id'));
        var_dump($request->getAttribute('oauth_scopes'));
    }
}
