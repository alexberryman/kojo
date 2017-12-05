<?php

namespace NHDS\Jobs\Semaphore\Mutex;

use NHDS\Jobs\Exception\Runtime\Filesystem as FilesystemException;
use NHDS\Jobs\Filesystem;

class Flock extends AbstractMutex
{
    use Filesystem\AwareTrait;
    protected $_fileName;
    protected $_directoryPath;
    protected $_filePointer;
    protected $_filePath;
    protected $_fileMode;
    protected $_directoryMode;
    protected $_hasLock = false;

    public function testAndSetLock(): bool
    {
        if ($this->_hasLock === false) {
            if (flock($this->_getLockFilePointer(), $this->_getFlockLockOperation()) === true) {
                $this->_hasLock = true;
            }
        }else {
            throw new \LogicException('The mutex already has obtained a lock.');
        }

        return $this->_hasLock;
    }

    protected function _getLockFilePointer()
    {
        if ($this->_filePointer === null) {
            if (!is_readable($this->_getFilePath())) {
                $this->_getFilesystem()->mkdir($this->_getDirectoryPath(), $this->_getDirectoryMode());
            }

            $filePointer = fopen($this->_getFilePath(), $this->_getFileMode());
            if (!is_resource($filePointer) || $filePointer === false) {
                $this->_throwNewFilesystemException(FilesystemException::CODE_FOPEN_FAILED);
            }
            $this->_filePointer = $filePointer;
        }

        return $this->_filePointer;
    }

    protected function _getFilePath()
    {
        if ($this->_filePath === null) {
            $this->_filePath = $this->_getDirectoryPath() . DIRECTORY_SEPARATOR . $this->_getFileName();
        }

        return $this->_filePath;
    }

    public function releaseLock(): MutexInterface
    {
        if ($this->_hasLock === true) {
            if (unlink($this->_getFilePath()) === false) {
                $this->_throwNewFilesystemException(FilesystemException::CODE_UNLINK_FAILED);
            }
            if (flock($this->_getLockFilePointer(), LOCK_UN) === false) {
                $this->_throwNewFilesystemException(FilesystemException::CODE_UNLOCK_FAILED);
            }
            $this->_hasLock = false;
            if (fclose($this->_getLockFilePointer()) === false) {
                $this->_throwNewFilesystemException(FilesystemException::CODE_FCLOSE_FAILED);
                $this->_filePointer = null;
            }
        }else {
            throw new \LogicException('The mutex has not obtained a lock.');
        }

        return $this;
    }

    public function setFileMode(string $fileMode)
    {
        if ($this->_fileMode === null) {
            $this->_fileMode = $fileMode;
        }else {
            throw new \LogicException('File mode is already set.');
        }

        return $this;
    }

    protected function _getFileMode()
    {
        if ($this->_fileMode === null) {
            throw new \LogicException('File mode is not set.');
        }

        return $this->_fileMode;
    }

    protected function _getDirectoryPath()
    {
        if ($this->_directoryPath === null) {
            $this->_directoryPath = $this->_getResource()->getResourcePath();
        }

        return $this->_directoryPath;
    }

    protected function _getFileName()
    {
        if ($this->_fileName === null) {
            $this->_fileName = $this->_getResource()->getResourceName();
        }

        return $this->_fileName;
    }

    protected function _getDirectoryMode()
    {
        if ($this->_directoryMode === null) {
            throw new \LogicException('Directory mode is not set.');
        }

        return $this->_directoryMode;
    }

    public function setDirectoryMode(int $directoryMode)
    {
        if ($this->_directoryMode === null) {
            $this->_directoryMode = $directoryMode;
        }else {
            throw new \LogicException('Directory mode is already set.');
        }

        return $this->_directoryMode;
    }

    protected function _getFlockLockOperation()
    {
        return $this->_getIsBlocking() ? LOCK_EX : LOCK_EX | LOCK_NB;
    }
}