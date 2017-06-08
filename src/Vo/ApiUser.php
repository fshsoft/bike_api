<?php

namespace Bike\Api\Vo;

use Bike\Api\Db\Primary\User;

class ApiUser
{
    protected $fields = array(
        'id' => null,
        'mobi' => null,
        'name' => null,
        'idno' => null,
        'certif' => null,
        'bal' => null,
        'avt' => null,
        'llip' => null,
        'llt' => null,
        'regt' => null,
    );

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

    public function toUser()
    {

    }

    public function toArray()
    {
        return $this->data;
    }

    public function fromArray(array $data)
    {

    }
}
