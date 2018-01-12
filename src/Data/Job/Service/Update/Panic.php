<?php

namespace NHDS\Jobs\Data\Job\Service\Update;

use NHDS\Jobs\Data\Job\ServiceAbstract;

class Panic extends ServiceAbstract implements PanicInterface
{
    public function save(): PanicInterface
    {
        $this->_getJobStateService()->setJob($this->_getJob());
        $this->_getJobStateService()->requestPanicked();
        $this->_getJobStateService()->applyRequest();
        $this->_getJob()->save();

        return $this;
    }
}