<?php
/*
 * This file is part of PHP-framework GI.
 *
 * PHP-framework GI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP-framework GI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP-framework GI. If not, see <https://www.gnu.org/licenses/>.
 */
namespace GI\FileSystem\FSO;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\FileSystem\FSO\Exception\Inexistent\ExceptionAwareTrait;

use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\Meta\MetaInterface;
use GI\FileSystem\FSO\Symlink\SymlinkInterface;
use GI\FileSystem\FSO\Symlink\URLHolder\URLHolderInterface;
use GI\FileSystem\Factory\FactoryInterface as FileSystemFactoryInterface;

abstract class AbstractFSO implements FSOInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    const DEFAULT_MODE = 0755;


    /**
     * @var string
     */
    private $path = '';

    /**
     * @var int
     */
    private $mode = self::DEFAULT_MODE;

    /**
     * @var MetaInterface
     */
    private $meta;


    /**
     * FSO constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        $this->meta = $this->getFactory()->createMeta($this);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->getPath();
    }

    /**
     * @return string
     */
    public function getBasename()
    {
        return pathinfo($this->path, PATHINFO_BASENAME);
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return pathinfo($this->path, PATHINFO_FILENAME);
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return MetaInterface
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param int $mode
     * @return static
     */
    public function setMode(int $mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return static
     */
    public function setModeToDefault()
    {
        $this->setMode(static::DEFAULT_MODE);

        return $this;
    }

    /**
     * @return FileSystemFactoryInterface
     */
    protected function getFactory()
    {
        return $this->giGetFileSystemFactory();
    }

    /**
     * @param int $up
     * @return FSODirInterface
     * @throws \Exception
     */
    public function createParent(int $up = 1)
    {
        if ($up < 1) {
            $this->giThrowInvalidMinimumException('Up', $up, 1);
        }

        $path = $this->path;

        for ($i = 1; $i <= $up; $i ++) {
            $path = dirname($path);
        }

        return $this->getFactory()->createDir($path);
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return file_exists($this->path);
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function fireInexistence()
    {
        if (!$this->exists()) {
           $this->throwFSOInexistentException();
        }

        return $this;
    }

    /**
     * @param string $path
     * @return SymlinkInterface
     * @throws \Exception
     */
    public function createSymlink(string $path)
    {
        return $this->getFactory()->createSymlink($path, $this);
    }

    /**
     * @param string $path
     * @return URLHolderInterface
     */
    public function createURLHolder(string $path)
    {
        return $this->getFactory()->createURLHolder($this, $path);
    }
}