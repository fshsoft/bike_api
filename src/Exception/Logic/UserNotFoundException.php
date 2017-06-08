<?php

namespace Bike\Api\Exception\Logic;

use Bike\Api\Error\ErrorCode;

class UserNotFoundException extends \Exception implements LogicExceptionInterface
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = '用户未找到';
        }

        parent::__construct($message, ErrorCode::LOGIC_ERROR_USER_NOT_FOUND);
    }
}
