<?php
declare(strict_types=1);

namespace NHDS\Jobs\Db;

use NHDS\Jobs\Exception\Runtime\Db\Model\LoadException;
use NHDS\Toolkit\Data\Property;
use NHDS\Jobs\Db;
use NHDS\Jobs\Db\Connection\ContainerInterface;
use Zend\Db\Sql\Select;

class Model implements ModelInterface
{
    use Property\Persistent\AwareTrait;
    use Db\Connection\Container\AwareTrait;
    protected $_idPropertyName;
    protected $_tableName;

    public function setTableName(string $tableName): ModelInterface
    {
        if ($this->_tableName === null) {
            $this->_tableName = $tableName;
        }else {
            throw new \LogicException('Table name is already set.');
        }

        return $this;
    }

    public function getTableName(): string
    {
        if ($this->_tableName === null) {
            throw new \LogicException('Table name is not set.');
        }

        return $this->_tableName;
    }

    public function getIdPropertyName(): string
    {
        if ($this->_idPropertyName === null) {
            throw new \LogicException('ID property name is not set.');
        }

        return $this->_idPropertyName;
    }

    public function setIdPropertyName(string $idPropertyName): ModelInterface
    {
        if ($this->_idPropertyName === null) {
            $this->_idPropertyName = $idPropertyName;
        }else {
            throw new \LogicException('ID property name is already set.');
        }

        return $this;
    }

    public function setId(int $id): ModelInterface
    {
        $this->_createPersistentProperty($this->getIdPropertyName(), $id);

        return $this;
    }

    public function load(string $propertyName = null, $propertyValue = null): ModelInterface
    {
        if ($propertyName === null) {
            $propertyName = $this->getIdPropertyName();
        }
        if ($propertyValue === null) {
            $propertyValue = $this->_readPersistentProperty($propertyName);
        }

        $select = $this->_getLoadSelect($propertyName, $propertyValue);
        $statement = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->getStatement($select);
        $data = $statement->execute()->current();

        if ($data) {
            $this->_hydrate($data);
        }else {
            throw (new LoadException())->setCode(LoadException::CODE_NO_DATA_LOADED);
        }

        return $this;
    }

    public function getId(): int
    {
        return (int)$this->_readPersistentProperty($this->getIdPropertyName());
    }

    public function hasId(): bool
    {
        return $this->_hasPersistentProperty($this->getIdPropertyName());
    }

    protected function _getLoadSelect($field, $value): Select
    {
        $select = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->select($this->getTableName());
        $select->where([$field => $value]);

        return $select;
    }

    public function save(): ModelInterface
    {
        if ($this->hasId()) {
            $this->update();
        }else {
            $this->insert();
        }

        return $this;
    }

    public function delete(): ModelInterface
    {
        $delete = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->delete($this->getTableName());
        $delete->where([$this->getIdPropertyName() => $this->getId()]);
        $statement = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->getStatement($delete);
        $statement->execute();
        $this->_emptyPersistentProperties();

        return $this;
    }

    protected function insert(): ModelInterface
    {
        $insert = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->insert($this->getTableName());
        $insert->values($this->_readChangedPersistentProperties());
        $statement = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->getStatement($insert);
        $statement->execute();
        $id = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->getDriver()->getLastGeneratedValue();
        $this->setId((int)$id);
        $this->_emptyChangedPersistentProperties();

        return $this;
    }

    protected function update(): ModelInterface
    {
        $changedPersistentProperties = $this->_readChangedPersistentProperties();
        $update = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->update($this->getTableName());
        $update->where([$this->getIdPropertyName() => $this->getId()]);
        $update->set($changedPersistentProperties);
        $statement = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->getStatement($update);
        $statement->execute();
        $this->_emptyChangedPersistentProperties();

        return $this;
    }
}