<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;
use Bike\Api\Util\ArgUtil;
use Bike\Api\Db\Primary\BikeIdGenerator;

class BikeService extends AbstractService
{
    public function generateBikeId()
    {
        $bikeIdGenerator = new BikeIdGenerator();
        $bikeIdGeneratorDao = $this->container->get('bike.api.dao.primary.bike_id_generator');
        return $bikeIdGeneratorDao->save($bikeIdGenerator, true);
    }
}
