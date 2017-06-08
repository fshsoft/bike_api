<?php

namespace Bike\Api\Controller\User;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Bike\Api\Controller\AbstractController;
use Bike\Api\Exception\Logic\UserNotFoundException;
use Bike\Api\Vo\ApiUser;

class CurrentController extends AbstractController
{
    public function getUserAction(Request $request, Response $response)
    {
        try {
            $userId = $request->getAttribute('oauth_user_id');
            $userService = $this->container->get('bike.api.service.user');
            $user = $userService->getUser($userId);
            if (!$user) {
                throw new UserNotFoundException();
            }
            $apiUser = new ApiUser();
            $apiUser->fromUser($user);
            $data = [
                'user' => $apiUser->toArray(),
            ];
            return $this->jsonSuccess($response, $data);
        } catch (\Exception $e) {
            return $this->jsonError($response, $e, '获取当前用户信息失败');
        }
    }
}
