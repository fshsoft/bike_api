<?php

namespace Bike\Api\Controller\Alipay;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class OrderController extends AbstractController
{
    public function httpPost(Request $request, Response $response)
    {
        $userId = $request->getAttribute('oauth_user_id');
        $clientId = $request->getAttribute('oauth_client_id');
        $alipayService = $this->container->get('bike.api.service.alipay');
    }
}
