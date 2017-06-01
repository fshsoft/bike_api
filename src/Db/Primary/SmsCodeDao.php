<?php

namespace Bike\Api\Db\Primary;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

use Bike\Api\Db\AbstractDao;

class SmsCodeDao extends AbstractDao
{
    protected function parseTable($cond, $dbOp)
    {
        return "`{$this->db}`.`{$this->prefix}sms_code`";
    }

    protected function applyWhere(QueryBuilder $qb, array $where, $dbOp)
    {

    }

    protected function applyOrder(QueryBuilder $qb, array $order)
    {

    }

    protected function applyGroup(QueryBuilder $qb, array $group)
    {

    }
}
