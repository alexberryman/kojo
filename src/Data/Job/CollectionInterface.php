<?php
declare(strict_types=1);

namespace Neighborhoods\Kojo\Data\Job;

use Neighborhoods\Kojo\Data\Job\Collection\IteratorInterface;
use Neighborhoods\Kojo\Db\Model;

interface CollectionInterface extends Model\CollectionInterface
{
    public function setIterator(IteratorInterface $iterator);

    public function getIterator(): IteratorInterface;
}