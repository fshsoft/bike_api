<?php

namespace Bike\Api\Exception\Logic;

use Bike\Api\Error\ErrorCode;

class InvalidRefreshTokenException extends \Exception implements LogicExceptionInterface
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = 'refresh_token不合法';
        }

        parent::__construct($message, ErrorCode::LOGIC_ERROR_INVALID_REFRESH_TOKEN);
    }
}
