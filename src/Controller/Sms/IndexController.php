<?php

namespace Bike\Api\Controller\Sms;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;
use Bike\Api\Exception\Logic\LogicException;

class IndexController extends AbstractController
{
    public function sendLoginCodeAction(Request $request, Response $response)
    {
        try {
            $mobile = $request->getQueryParam('mobi');
            $smsService = $this->container->get('bike.api.service.sms');
            $smsService->sendLoginCode($mobile);
            return $this->jsonSuccess($response);
        } catch (\Exception $e) {
            return $this->jsonError($response, $e, '发送验证码失败');
        }
    }
}
