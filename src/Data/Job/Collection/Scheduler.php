<?php

namespace NHDS\Jobs\Data\Job\Collection;

use NHDS\Jobs\Data\Job\Collection;
use NHDS\Jobs\Data\JobInterface;
use NHDS\Jobs\Db\Connection\ContainerInterface;
use NHDS\Toolkit\TimeInterface;

class Scheduler extends Collection implements SchedulerInterface
{
    const PROP_DATE_TIME = 'date_time';

    public function setReferenceDateTime(\DateTime $dateTime): Scheduler
    {
        $this->_create(self::PROP_DATE_TIME, $dateTime);

        return $this;
    }

    protected function _getReferenceDateTime(): \DateTime
    {
        return $this->_read(self::PROP_DATE_TIME);
    }

    protected function &_getRecords(): array
    {
        if (!$this->_exists(self::PROP_RECORDS)) {
            $select = $this->getSelect();
            $select->columns([JobInterface::FIELD_NAME_TYPE_CODE, JobInterface::FIELD_NAME_WORK_AT_DATETIME]);
            $workAtDateTime = $this->_getReferenceDateTime()->format(TimeInterface::MYSQL_DATETIME_FORMAT);
            $select->where(JobInterface::FIELD_NAME_WORK_AT_DATETIME . '>= "' . $workAtDateTime . '"');
            $statement = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->getStatement($select);
            /** @var \PDOStatement $pdoStatement */
            $pdoStatement = $statement->execute()->getResource();
            $pdoStatement->setFetchMode(\PDO::FETCH_NUM);
            $records = [];
            while ($record = $pdoStatement->fetch()) {
                $records[$record[0]][$record[1]] = 1;
            }
            if ($records === false) {
                $this->_create(self::PROP_RECORDS, []);
            }else {
                $this->_create(self::PROP_RECORDS, $records);
            }
        }

        return $this->_read(self::PROP_RECORDS);
    }
}