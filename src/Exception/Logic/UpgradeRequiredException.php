<?php

namespace Bike\Api\Exception\Logic;

use Bike\Api\Error\ErrorCode;

class UpgradeRequiredException extends \Exception implements LogicExceptionInterface
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = '版本需要升级';
        }

        parent::__construct($message, ErrorCode::LOGIC_ERROR_UPGRADE_REQUIRED);
    }
}
