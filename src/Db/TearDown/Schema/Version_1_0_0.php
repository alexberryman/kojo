<?php
declare(strict_types=1);

namespace Neighborhoods\Kojo\Db\TearDown\Schema;

use Neighborhoods\Kojo\Data\Status\TypeInterface;
use Neighborhoods\Kojo\Db\Schema\VersionAbstract;
use Neighborhoods\Kojo\Db\Schema\VersionInterface;

class Version_1_0_0 extends VersionAbstract
{
    protected function _assembleSchemaChanges(): VersionInterface
    {
        $this->setTableName(TypeInterface::TABLE_NAME);

        return $this;
    }
}
