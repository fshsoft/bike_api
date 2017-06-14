<?php

namespace Bike\Api\Controller\Bike;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    //@todo 假数据
    public function httpGet(Request $request, Response $response, $id)
    {
        try {
            $data = [
                'dura' => 30,
                'amou' => 1.56,
            ];
            return $this->jsonSuccess($response, $data);
        } catch (\Exception $e) {
            return $this->jsonError($response, $e, '暂时无法获取结账信息');
        }
    }

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
