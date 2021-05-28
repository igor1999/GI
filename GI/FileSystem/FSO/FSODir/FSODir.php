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
namespace GI\FileSystem\FSO\FSODir;

use GI\FileSystem\FSO\AbstractFSO;
use GI\FileSystem\FSO\FSODir\Behaviour\Nodes;
use GI\FileSystem\FSO\FSODir\Behaviour\Children;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\FSO\Symlink\SymlinkInterface;
use GI\FileSystem\FSO\FSODir\Behaviour\ChildrenInterface;
use GI\FileSystem\FSO\FSODir\Behaviour\NodesInterface;

class FSODir extends AbstractFSO implements FSODirInterface
{
    /**
     * @param string $path
     * @return FSODirInterface
     */
    public function createChildDir(string $path)
    {
        return $this->getFactory()->createDir($this->getPath() . '/' . $path);
    }

    /**
     * @param string $path
     * @return FSOFileInterface
     */
    public function createChildFile(string $path)
    {
        return $this->getFactory()->createFile($this->getPath() . '/' . $path);
    }

    /**
     * @param string $path
     * @return SymlinkInterface
     */
    public function createChildSymlink(string $path)
    {
        return $this->getFactory()->createSymlink($this->getPath() . '/' . $path);
    }

    /**
     * @return static
     */
    public function create()
    {
        if (!$this->exists()) {
            mkdir($this->getPath(), $this->getMode(), true);
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->exists()) {
            $this->getChildren()->delete();

            rmdir($this->getPath());
        }

        return $this;
    }

    /**
     * @param FSODirInterface $dir
     * @return static
     * @throws \Exception
     */
    public function makeCopy(FSODirInterface $dir)
    {
        $this->fireInexistence();

        $dir->create();

        $this->getChildren()->makeCopy($dir);

        return $this;
    }

    /**
     * @param FSODirInterface $dir
     * @return static
     * @throws \Exception
     */
    public function move(FSODirInterface $dir)
    {
        $this->fireInexistence();

        rename($this->getPath(), $dir->getPath());

        return $this;
    }

    /**
     * @return bool
     */
    public function isDir()
    {
        return is_dir($this->getPath());
    }

    /**
     * @return ChildrenInterface
     * @throws \Exception
     */
    public function getChildren()
    {
        try {
            $children = $this->getGiServiceLocator()->getDependency(ChildrenInterface::class,null, [$this]);
        } catch (\Exception $e) {
            $children = new Children($this);
        }

        return $children;
    }

    /**
     * @return NodesInterface
     * @throws \Exception
     */
    public function getNodes()
    {
        try {
            $nodes = $this->getGiServiceLocator()->getDependency(NodesInterface::class,null, [$this]);
        } catch (\Exception $e) {
            $nodes = new Nodes($this);
        }

        return $nodes;
    }
}