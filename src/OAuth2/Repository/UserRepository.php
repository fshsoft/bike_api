<?php

namespace Bike\Api\OAuth2\Repository;

use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

use Bike\Api\OAuth2\Entity\UserEntity;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * username 是 mobile
     * password 是 sms code
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    )
    {
        $userService = $this->container->get('bike.api.service.user');
        $user = $userService->getUserByMobile($username);
        $smsService = $this->container->get('bike.api.service.sms');
        if ($user && $smsService->verifyLoginCode($username, $password)) {
            $userEntity = new UserEntity();
            $userEntity->setIdentifier($user->getId());
            return $userEntity;
        }
    }
}
