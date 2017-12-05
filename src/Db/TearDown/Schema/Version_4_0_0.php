<?php

namespace NHDS\Jobs\Db\TearDown\Schema;

use NHDS\Jobs\Db\Schema\AbstractVersion;
use NHDS\Jobs\Db\Schema\VersionInterface;
use NHDS\Jobs\Data\Job\Type;
use Zend\Db\Sql\Ddl\DropTable;

class Version_4_0_0 extends AbstractVersion
{
    public function assembleSchemaChanges(): VersionInterface
    {
        $dropTable = new DropTable(Type::TABLE_NAME);
        $this->_setSchemaChanges($dropTable);

        return $this;
    }
}