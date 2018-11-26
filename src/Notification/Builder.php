<?php

namespace Neighborhoods\Kojo\Notification;

use Neighborhoods\Kojo\NotificationInterface;

class Builder implements BuilderInterface
{
    use \Neighborhoods\Kojo\Notification\Factory\AwareTrait;

    /** @var array */
    protected $record = null;

    public function build(): NotificationInterface
    {
        $Notification = $this->getRETS1NotificationFactory()->create();

        return $Notification;
    }

    protected function getRecord(): array
    {
        if ($this->record === null) {
            throw new \LogicException('Builder record has not been set.');
        }

        return $this->record;
    }

    public function setRecord(array $record): BuilderInterface
    {
        if ($this->record !== null) {
            throw new \LogicException('Builder record is already set.');
        }

        $this->record = $record;

        return $this;
    }
}

