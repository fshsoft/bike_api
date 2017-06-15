<?php

namespace Bike\Api\Service;

class OptionService extends AbstractService
{
    protected function getAutoloadOptionMapAsName()
    {
        $key = 'option.map';
        $optionMap = $this->getRequestCache($key);
        if (!$optionMap) {
            $optionDao = $this->container->get('bike.api.dao.primary.option');
            $optionList = $optionDao->findList('', [
                'autoload' => 1,
            ], 0, 0);
            if ($optionList) {

            }
        }
    }
}
