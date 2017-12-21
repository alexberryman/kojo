<?php

namespace NHDS\Jobs\Data\Job\Service\Update\Work;

use NHDS\Jobs\Data\Job\Service\Update\WorkInterface;
use NHDS\Jobs\Data\Job\State\Service;
use NHDS\Toolkit\Data\Property\Crud;
use NHDS\Jobs\Data\Job\Service\Update\Work;

class Factory implements FactoryInterface
{
    use Crud\AwareTrait;
    use Work\AwareTrait;
    use Service\AwareTrait;
    const PROP_FACTORY_NAME = 'factory_name';

    public function create(): WorkInterface
    {
        $updateCrash = $this->_getJobServiceUpdateWorkClone();
        $stateService = $this->_getJobStateServiceClone();
        $updateCrash->setJobStateService($stateService);

        return $updateCrash;
    }

    public function setName(string $factoryName): FactoryInterface
    {
        $this->_create(self::PROP_FACTORY_NAME, $factoryName);

        return $this;
    }

    public function getName(): string
    {
        return $this->_read(self::PROP_FACTORY_NAME);
    }
}