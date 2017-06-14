<?php

namespace Bike\Api\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface;

use Bike\Api\Error\ErrorCode;
use Bike\Api\Exception\Logic\LogicExceptionInterface;

abstract class AbstractController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request)
    {
        $action = 'http' . ucfirst(strtolower($request->getMethod()));
        return call_user_func_array([$this, $action], func_get_args());
    }

    protected function jsonSuccess(Response $response, $data = null)
    {
        $result = [
            'errno' => ErrorCode::SUCCESS,
            'errmsg' => '',
        ];
        if ($data !== null) {
            $result['data'] = $data;
        }
        return $response->withJson($result);
    }

    protected function jsonError(Response $response, $errno, $defaultErrmsg = null, $data = null)
    {
        if ($errno instanceof LogicExceptionInterface) {
            $result = [
                'errno' => $errno->getCode(),
                'errmsg' => $errno->getMessage(),
            ];
        } else {
            $errmsg = '出错了';
            if ($defaultErrmsg) {
                $errmsg = $defaultErrmsg;
            }
            $result = [
                'errno' => ErrorCode::LOGIC_ERROR,
                'errmsg' => $errmsg,
            ];
        }

        if ($data !== null) {
            $result['data'] = $data;
        }

        return $response->withJson($result);
    }
}
