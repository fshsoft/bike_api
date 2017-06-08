<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;
use Bike\Api\Util\ArgUtil;
use Bike\Api\Db\Primary\User;

class UserService extends AbstractService
{
    public function createUser(array $data)
    {
        $data = ArgUtil::getArgs($data, array(
            'mobile',
        ));
        $this->validateMobile($data['mobile']);
        $user = $this->getUserByMobile($data['mobile']);
        if ($user) {
            throw new LogicException('手机号码已存在');
        }
        $userDao = $this->getUserDao();
        $user = new User();
        $user
            ->setMobile($data['mobile'])
            ->setCreateTime(time());
        return $userDao->create($user, true);
    }

    public function getUserByMobile($mobile)
    {
        $key = 'user.mobile.' . $mobile;
        $user = $this->getRequestCache($key);
        if (!$user) {
            $userDao = $this->getUserDao();
            $user = $userDao->find(array(
                'mobile' => $mobile,
            ));
            if ($user) {
                $this->setUserRequestCache($user);
            }
        }
        return $user;
    }

    public function getUser($id)
    {
        $key = 'user.' . $id;
        $user = $this->getRequestCache($key);
        if (!$user) {
            $userDao = $this->getUserDao();
            $user = $userDao->find($id);
            if ($user) {
                $this->setUserRequestCache($user);
            }
        }
        return $user;
    }

    public function hashPassword($password)
    {
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];

        return  password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    protected function setUserRequestCache(User $user)
    {
        $mobikeKey = 'user.mobile.' . $user->getMobile();
        $idKey = 'user.' . $user->getId();
        $this->setRequestCache($mobikeKey, $user);
        $this->setRequestCache($idKey, $user);
    }

    protected function validateMobile($mobile)
    {
        if (!$mobile) {
            throw new LogicException('手机号码不能为空');
        } elseif (!preg_match('/^1\d{10}$/', $mobile)) {
            throw new LogicException('手机号码不合法');
        }
    }

    protected function getUserDao()
    {
        return $this->container->get('bike.api.dao.primary.user');
    }
}
