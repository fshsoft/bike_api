<?php

namespace Bike\Api\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface;

use Bike\Api\Error\ErrorCode;
use Bike\Api\Exception\Logic\LogicExceptionInterface;
use Bile\Api\Service\ApiService;

abstract class AbstractController
{
    protected $container;

    protected $apiService;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->apiService = $this->container->get('bike.api.service.api');
    }

    public function __invoke(Request $request)
    {
        $action = 'http' . ucfirst(strtolower($request->getMethod()));
        return call_user_func_array([$this, $action], func_get_args());
    }

    protected function jsonSuccess(Response $response, $data = null)
    {
        $result = $this->apiService->handleSuccess($data);
        return $response->withJson($result);
    }

    protected function jsonError(Response $response, $errno, $defaultErrmsg = null, $data = null)
    {
        $result = $this->handleError($errno, $defaultErrmsg, $data);
        return $response->withJson($result);
    }
}
