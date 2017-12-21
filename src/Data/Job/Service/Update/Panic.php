<?php

namespace NHDS\Jobs\Data\Job\Service\Update;

use NHDS\Jobs\Data\Job\AbstractService;

class Panic extends AbstractService implements PanicInterface
{
    public function save(): PanicInterface
    {
        $this->_getJobStateService()->requestPanicked();
        $this->_getJob()->save();

        return $this;
    }
}