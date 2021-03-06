<?php
declare(strict_types=1);

namespace Neighborhoods\Kojo\Service\Create;

use Neighborhoods\Kojo\Service\CreateInterface;
use Neighborhoods\Kojo\State\Service;
use Neighborhoods\Kojo\Service\FactoryAbstract;
use Neighborhoods\Kojo\Service\Create;
use Neighborhoods\Kojo\Data\Job;

class Factory extends FactoryAbstract implements FactoryInterface
{
    use Create\AwareTrait;
    use Service\AwareTrait;
    use Job\Type\AwareTrait;
    use Job\AwareTrait;
    use Job\Collection\ScheduleLimit\AwareTrait;

    public function create(): CreateInterface
    {
        $create = $this->_getServiceCreateClone();
        $stateService = $this->_getStateServiceClone();
        $create->setStateService($stateService);
        $create->setJobCollectionScheduleLimit($this->_getJobCollectionScheduleLimitClone());
        $create->setJob($this->_getJobClone());

        return $create;
    }
}