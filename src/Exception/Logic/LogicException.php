<?php

namespace Bike\Api\Exception\Logic;

use Bike\Api\Error\ErrorCode;

class LogicException extends \Exception implements LogicExceptionInterface
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = '出错了';
        }

        parent::__construct($message, ErrorCode::LOGIC_ERROR);
    }
}
