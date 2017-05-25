<?php

namespace Bike\Api\OAuth2\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

class ScopeEntity implements ScopeEntityInterface
{
    /*
     * @var string
     */
    protected $identifier;

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function jsonSerialize()
    {
        return $this->getIdentifier();
    }
}
