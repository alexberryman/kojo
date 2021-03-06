<?php
declare(strict_types=1);

namespace Neighborhoods\Kojo\Data\Job\Type;

use Neighborhoods\Kojo\Data\Job\TypeInterface;

trait AwareTrait
{
    public function setJobType(TypeInterface $jobType): self
    {
        $this->_create(TypeInterface::class, $jobType);

        return $this;
    }

    protected function _getJobType(): TypeInterface
    {
        return $this->_read(TypeInterface::class);
    }

    protected function _getJobTypeClone(): TypeInterface
    {
        return clone $this->_getJobType();
    }

    public function hasJobType(): bool
    {
        return $this->_exists(TypeInterface::class);
    }

    protected function _unsetJobType(): self
    {
        $this->_delete(TypeInterface::class);

        return $this;
    }
}