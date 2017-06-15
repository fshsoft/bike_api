<?php

namespace Bike\Api\Service;

use Bike\Api\Error\ErrorCode;
use Bike\Api\Exception\Logic\LogicExceptionInterface;

class ApiService extends AbstractService
{
    public function handleSuccess($data = null)
    {
        $result = [
            'errno' => ErrorCode::SUCCESS,
            'errmsg' => '',
        ];
        if ($data !== null) {
            $result['data'] = $data;
        }
        return $result;
    }

    public function handleError($errno, $defaultErrmsg = null, $data = null)
    {
        if ($errno instanceof LogicExceptionInterface) {
            $result = [
                'errno' => $errno->getCode(),
                'errmsg' => $errno->getMessage(),
            ];
        } else {
            $errmsg = '出错了';
            if ($defaultErrmsg) {
                $errmsg = $defaultErrmsg;
            }
            $result = [
                'errno' => ErrorCode::LOGIC_ERROR,
                'errmsg' => $errmsg,
            ];
        }

        if ($data !== null) {
            $result['data'] = $data;
        }

        return $result;
    }

    public function isVersionValid($clientId, $version)
    {
        $optionDao = $this->container->get('bike.api.dao.primary.option');
        $name = $clientId . '_min_api_ver';
        $option = $optionDao->find([
            'name' => $name,
        ]);
        if ($option) {
            $minApiVersion = $option->getVal();
        } else {
            $minApiVersion = '0.0.1';
        }
        if (version_compare($version, $minApiVersion, '>=')) {
            return true; 
        }
        return false;
    }
}
