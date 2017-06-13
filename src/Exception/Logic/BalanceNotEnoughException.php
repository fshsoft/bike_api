<?php

namespace Bike\Api\Exception\Logic;

use Bike\Api\Error\ErrorCode;

class BalanceNotEnoughException extends \Exception implements LogicExceptionInterface
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = '余额不足，请先充值';
        }

        parent::__construct($message, ErrorCode::LOGIC_ERROR_BALANCE_NOT_ENOUGH);
    }
}
