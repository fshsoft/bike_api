<?php

namespace Bike\Api\Vo;

use Bike\Api\Db\Primary\Bike;

class ApiBike
{
    protected $fields = [
        'id' => null,
        'lat' => null,
        'lng' => null,
    ];

    protected $data = [];

    public function fromBike(Bike $bike)
    {
        $this->data = [
            'id' => $bike->getId(),
            'lat' => $bike->getLat(),
            'lng' => $bike->getLng(),
        ];
    }

    public function toArray()
    {
        return $this->data;
    }
}
