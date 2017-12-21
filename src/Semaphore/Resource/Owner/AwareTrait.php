<?php

namespace NHDS\Jobs\Semaphore\Resource\Owner;

use NHDS\Jobs\Semaphore\Resource\OwnerInterface;

trait AwareTrait
{
    public function setSemaphoreResourceOwner(OwnerInterface $semaphoreReourceOwner)
    {
        $this->_create(OwnerInterface::class, $semaphoreReourceOwner);

        return $this;
    }

    protected function _hasSemaphoreResourceOwner(): bool
    {
        return $this->_exists(OwnerInterface::class);
    }

    protected function _getSemaphoreResourceOwner(): OwnerInterface
    {
        return $this->_read(OwnerInterface::class);
    }

    protected function _getSemaphoreResourceOwnerClone(): OwnerInterface
    {
        return clone $this->_getSemaphoreResourceOwner();
    }
}