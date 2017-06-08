<?php

namespace Bike\Api\Vo;

use Bike\Api\Db\Primary\User;

class ApiUser
{
    protected $data = array();

    public function fromUser(User $user)
    {
        $this->data = array(
            'id' => $user->getId(),
            'mobi' => $user->getMobile(),
            'name' => $user->getName(),
            'idno' => $user->getIdNo(),
            'certif' => $user->getIsCertificated(),
            'bal' => $user->getBalance(),
            'avt' => $user->getAvatar(),
            'llip' => $user->getLastLoginIp(),
            'llt' => $user->getLastLoginTime(),
            'regt' => $user->getCreateTime(),
        );
    }

    public function toArray()
    {
        return $this->data;
    }
}
