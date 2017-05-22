<?php

namespace Bike\Api\Db;

interface EntityResultSetInterface
{
    public function toArray();

    public function toArrayForInsert();

    public function toArrayForUpdate();

    public function fromArray(array $data);
}
