<?php

namespace Bike\Api\Db\OAuth2;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

use Bike\Api\Db\AbstractDao;
use Bike\Api\Util\ArgUtil;

class ClientDao extends AbstractDao
{
    protected function parseTable($cond, $dbOp)
    {
        return "`{$this->db}`.`{$this->prefix}client`";
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
