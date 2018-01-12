<?php

namespace NHDS\Jobs\Data\Job\Service\Update\Retry;

use NHDS\Jobs\Data\Job\Service\Update\RetryInterface;
use NHDS\Jobs\Data\Job\State\ServiceInterface;
use NHDS\Jobs\Service;

interface FactoryInterface extends Service\FactoryInterface
{
    public function setJobStateService(ServiceInterface $jobStateService);

    public function setUpdateRetry(RetryInterface $updateRetry);

    public function setName(string $factoryName): FactoryInterface;

    public function create(): RetryInterface;
}