<?php

namespace Bike\Api\Controller\Bike;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    //@todo 假数据
    public function httpPut(Request $request, Response $response, $id)
    {
        try {
            return $this->jsonSuccess($response);
        } catch (\Exception $e) {
            return $this->jsonError($response, $e, '结账失败，请稍后再试');
        }
    }
}
