<?php

namespace Bike\Api\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    public function indexAction(Request $request, Response $response)
    {
        $userService = $this->container->get('bike.api.service.user');
        echo get_class($userService);
    }
}
