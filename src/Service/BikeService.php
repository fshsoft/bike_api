<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Debug\DebugException;
use Bike\Api\Exception\Logic\LogicException;
use Bike\Api\Service\AbstractService;
use Bike\Api\Util\ArgUtil;
use Bike\Api\Db\Primary\Bike;
use Bike\Api\Db\Primary\BikeSnGenrator;

class BikeService extends AbstractService
{
    public function getBikeBySn($sn)
    {
        $key = 'bike.sn.' . $sn;
        $bike = $this->getRequestCache($key);
        if (!$bike) {
            $bikeDao = $this->getBikeDao();
            $bike = $bikeDao->find(array(
                'sn' => $sn,
            ));
            if ($bike) {
                $this->setRequestCache($key, $bike);
            }
        }
        return $bike;
    }

    protected function generateBikeSn()
    {
        $bikeSnGeneratorDao = $this->getBikeSnGeneratorDao();
        return $bikeSnGeneratorDao->save(array(), true);
    }

    protected function getBikeDao()
    {
        return $this->container->get('bike.api.dao.primary.bike');
    }

    protected function getBikeSnGeneratorDao()
    {
        return $this->container->get('bike.api.dao.primary.bike_sn_generator');
    }
}
