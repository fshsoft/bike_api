<?php

namespace Bike\Api\OAuth2\Repository;

use Interop\Container\ContainerInterface;

abstract class AbstractRepository
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
