<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;

class AliyunService extends AbstractService
{
    protected $accessKeyId;

    protected $accessKeySecret;

    protected $regions;

    protected $clients;

    public function setAccessKeyId($accessKeyId)
    {
        $this->accessKeyId = $accessKeyId;
        return $this;
    }

    public function setAccessKeySecret($accessKeySecret)
    {
        $this->accessKeySecret = $accessKeySecret;
        return $this;
    }

    public function setRegions(array $regions)
    {
        $this->regions = $regions;
        return $this;
    }

    public function getClient($regionId)
    {
        if (!isset($this->clients[$regionId])) {
            if (!in_array($regionId, $this->regions)) {
                throw new DebugException('不存在的阿里云region id');
            }
            $iClientProfile = \DefaultProfile::getProfile($regionId, $this->accessKeyId, $this->accessKeySecret);        
            $client = new \DefaultAcsClient($iClientProfile);
            $this->clients[$regionId] = $client;
        }
        return $this->clients[$regionId];
    }
}
