<?php

namespace Bike\Api\Controller\Bike;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;

class UseController extends AbstractController
{
    public function httpPost(Request $request, Response $response, $id)
    {
        try {
            $userId = $request->getAttribute('oauth_user_id');
            $lat = $request->getParsedBodyParam('lat');
            $lng = $request->getParsedBodyParam('lng');
            $bikeService = $this->container->get('bike.api.service.bike');
            $bikeService->useBike($userId, $lat, $lng, $id);
            return $this->jsonSuccess($response);
        } catch (\Exception $e) {
            return $this->jsonError($response, $e, '车辆暂时无法使用');
        }
    }
}
