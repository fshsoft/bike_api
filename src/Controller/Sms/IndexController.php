<?php

namespace Bike\Api\Controller\Sms;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function sendLoginCodeAction(Request $request, Response $response)
    {
        try {
            $smsService = $this->container->get('bike.api.service.sms');
            $code = $smsService->sendLoginCode($request->getQueryParam('mobile'));
            return $this->jsonSuccess($response, array('code' => $code));
        } catch (\Exception $e) {
            return $this->jsonError($response, $e, '发送验证码失败');
        }
    }
}
