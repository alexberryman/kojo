<?php

namespace NHDS\Jobs\Data\Job\Service\Update\Complete\Success;

use NHDS\Jobs\Data\Job\Service\Update\Complete\SuccessInterface;
use NHDS\Jobs\Data\Job\State\ServiceInterface;
use NHDS\Jobs\Service;

interface FactoryInterface extends Service\FactoryInterface
{
    public function setJobStateService(ServiceInterface $jobStateService);

    public function setUpdateCompleteSuccess(SuccessInterface $updateCompleteSuccess);

    public function setName(string $factoryName): FactoryInterface;

    public function create(): SuccessInterface;
}