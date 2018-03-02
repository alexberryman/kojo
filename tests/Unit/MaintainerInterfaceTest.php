<?php
declare(strict_types=1);

namespace NHDS\Jobs\Test\Unit;

use Neighborhoods\Scaffolding\Fixture;

class MaintainerInterfaceTest extends Fixture\AbstractTest
{
    public function testDelete()
    {
        $maintainer = $this->_getTestContainerBuilder()->get('nhds.jobs.maintainer');
        $maintainer->deleteCompletedJobs();

        return $this;
    }

    public function testUpdatePendingJobs()
    {
        $maintainer = $this->_getTestContainerBuilder()->get('nhds.jobs.maintainer');
        $maintainer->updatePendingJobs();

        return $this;
    }

    public function testRescheduleCrashedJobs()
    {
        $maintainer = $this->_getTestContainerBuilder()->get('nhds.jobs.maintainer');
        $maintainer->rescheduleCrashedJobs();

        return $this;
    }
}