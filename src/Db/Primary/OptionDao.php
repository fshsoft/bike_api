<?php

namespace Bike\Api\Db\Primary;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

use Bike\Api\Db\AbstractDao;
use Bike\Api\Util\ArgUtil;

class OptionDao extends AbstractDao
{
    protected function parseTable($cond, $dbOp)
    {
        return "`{$this->db}`.`{$this->prefix}option`";
    }

    protected function applyWhere(QueryBuilder $qb, array $where, $dbOp)
    {
        if (!$where) {
            return;
        }

        $where = ArgUtil::getArgs($where, [
            'id',
            'name',
            'autoload',
        ]);
        if ($where['id']) {
            $qb->andWhere('id = ' . $qb->createNamedParameter($where['id']));
        }
        if ($where['name']) {
            $qb->andWhere('name = ' . $qb->createNamedParameter($where['name']));
        }
        if ($where['autoload']) {
            $qb->andWhere('autoload = ' . $qb->createNamedParameter($where['autoload']));
        }
    }

    protected function applyOrder(QueryBuilder $qb, array $order)
    {
        if (!$order) {
            return;
        }

        $order = ArgUtil::getArgs($order, [
            'order_no',
        ]);
        foreach ($order as $col => $sort) {
            $qb->addOrderBy($col, $sort);
        }
    }

    protected function applyGroup(QueryBuilder $qb, array $group)
    {

    }
}
