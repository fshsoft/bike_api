<?php

namespace Bike\Api\Controller\User;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function testAction(Request $request, Response $response)
    {
        echo 111;
    }
}
