<?php
declare(strict_types=1);

namespace Neighborhoods\Kojo\Exception\Runtime\Filesystem;

use Neighborhoods\AreaService\Exception\Runtime;

class Exception extends Runtime\Exception
{
    const CODE_PREFIX = self::class . '-';
    const CODE_UNLOCK_FAILED = self::CODE_PREFIX . 'unlock_failed';
    const CODE_FOPEN_FAILED = self::CODE_PREFIX . 'fopen_failed';
    const CODE_FCLOSE_FAILED = self::CODE_PREFIX . 'fclose_failed';
    const CODE_UNLINK_FAILED = self::CODE_PREFIX . 'unlink_failed';

    public function __construct($message = null, $code = 0, \Throwable $previous = null)
    {
        $this->addPossibleMessage(self::CODE_UNLOCK_FAILED, 'Failed to unlock the file.');
        $this->addPossibleMessage(self::CODE_FOPEN_FAILED, 'Failed to open the file.');
        $this->addPossibleMessage(self::CODE_FCLOSE_FAILED, 'Failed to close the file.');
        $this->addPossibleMessage(self::CODE_UNLINK_FAILED, 'Failed to unlink the file.');

        return parent::__construct($message, $code, $previous);
    }
}