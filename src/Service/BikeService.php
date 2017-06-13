<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;
use Bike\Api\Exception\Logic\UserNotFoundException;
use Bike\Api\Exception\Logic\BalanceNotEnoughException;
use Bike\Api\Util\ArgUtil;
use Bike\Api\Db\Primary\BikeIdGenerator;
use Bike\Api\Db\Primary\Bike;

class BikeService extends AbstractService
{
    public function useBike($userId, $userLat, $userLng, $bikeId)
    {
        $bike = $this->getBike($bikeId);
        if (!$bike) {
            throw new LogicException('车辆不存在');
        }
        switch ($bike->getStatus()) {
            case Bike::STATUS_CAN_USE:
                break;
            case Bike::STATUS_UNLOCKING:
                throw new LogicException('车辆开锁中,无法使用');
            case Bike::STATUS_IN_USE:
                throw new LogicException('车辆正在使用中，无法使用');
            case Bike::LOCKING:
                throw new LogicException('车辆关锁中，无法使用');
            case Bike::CHECKOUTING:
                throw new LogicException('车辆结账中，无法使用');
            case Bike::STATUS_BROKEN:
                throw new LogicException('这辆车是坏的');
            default:
                throw new LogicException('这辆车暂时不能使用');
        }
        // @todo 判断使用者是否在车辆附近

        $userService = $this->container->get('bike.api.service.user');
        $user = $userService->getUser($userId);
        if (!$user) {
            throw new UserNotFoundException();
        }
        if ($user->getBalance() < 1) {
            throw new BalanceNotEnoughException();
        }
        $bikeDao = $this->getBikeDao();
        // @todo 目前直接更新车辆状态到使用中，待
        // 锁调通后，更新到开锁中状态
        $bikeDao->update($bikeId, array(
            'user_id' => $userId,
            'status' => Bike::STATUS_IN_USE,
        ));
    }

    public function getBike($id)
    {
        $key = $this->getRequestCacheKey('bike.id', $id);
        $bike = $this->getRequestCache($key);
        if (!$bike) {
            $bikeDao = $this->getBikeDao();
            $bike = $bikeDao->find($id);
            if ($bike) {
                $this->setRequestCache($key, $bike);
            }
        }
        return $bike;
    }

    public function generateBikeId()
    {
        $bikeIdGenerator = new BikeIdGenerator();
        $bikeIdGeneratorDao = $this->container->get('bike.api.dao.primary.bike_id_generator');
        return $bikeIdGeneratorDao->save($bikeIdGenerator, true);
    }

    protected function getBikeDao()
    {
        return $this->container->get('bike.api.dao.primary.bike');
    }
}
