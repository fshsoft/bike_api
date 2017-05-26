<?php

namespace Bike\Api\Exception\Logic;

use Bike\Api\Error\ErrorCode;

class InvalidAccessTokenException extends \Exception implements LogicExceptionInterface
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = 'access_token不合法';
        }

        parent::__construct($message, ErrorCode::LOGIC_ERROR_INVALID_ACCESS_TOKEN);
    }
}
