<?php

namespace NHDS\Jobs\Semaphore\Resource\Factory;

use NHDS\Jobs\Semaphore\Resource\FactoryInterface;
use NHDS\Jobs\Semaphore\ResourceInterface;

trait AwareTrait
{
    protected $_semaphoreResourceFactories = [];
    protected $_cachedSemaphoreResources   = [];

    public function addSemaphoreResourceFactory(FactoryInterface $semaphoreResourceFactory)
    {
        if (!isset($this->_semaphoreResourceFactories[$semaphoreResourceFactory->getName()])) {
            $this->_semaphoreResourceFactories[$semaphoreResourceFactory->getName()] = $semaphoreResourceFactory;
        }else {
            $factoryName = $semaphoreResourceFactory->getName();
            throw new \LogicException('Semaphore resource factory with name "' . $factoryName . '" is already set.');
        }

        return $this;
    }

    protected function _getSemaphoreResourceFactory(string $factoryName): FactoryInterface
    {
        if (!isset($this->_semaphoreResourceFactories[$factoryName])) {
            throw new \LogicException('Semaphore resource factory with name "' . $factoryName . '" is not set.');
        }

        return $this->_semaphoreResourceFactories[$factoryName];
    }

    protected function _getCachedSemaphoreResource(string $semaphoreResourceFactoryName): ResourceInterface
    {
        if (!isset($this->_cachedSemaphoreResources[$semaphoreResourceFactoryName])) {
            $semaphoreResourceFactory = $this->_getSemaphoreResourceFactory($semaphoreResourceFactoryName);
            $this->_cachedSemaphoreResources[$semaphoreResourceFactoryName] = $semaphoreResourceFactory->create();
        }

        return $this->_cachedSemaphoreResources[$semaphoreResourceFactoryName];
    }

    protected function _getNewSemaphoreResource(string $semaphoreResourceFactoryName): ResourceInterface
    {
        return $this->_getSemaphoreResourceFactory($semaphoreResourceFactoryName)->create();
    }
}