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
namespace GI\FileSystem\FSO\Symlink;

use GI\FileSystem\FSO\AbstractFSO;

use GI\FileSystem\FSO\FSOInterface;

class Symlink extends AbstractFSO implements SymlinkInterface
{
    /**
     * @var FSOInterface
     */
    private $target;


    /**
     * Symlink constructor.
     * @param string $path
     * @param FSOInterface|null $target
     */
    public function __construct(string $path, FSOInterface $target = null)
    {
        parent::__construct($path);

        $this->setTarget($target);
    }

    /**
     * @return FSOInterface
     * @throws \Exception
     */
    public function getRealTarget()
    {
        $this->fireInexistence();

        if (!$this->isLink()) {
            $this->giThrowInvalidTypeException('File', $this->getPath(), 'Symlink');
        }

        $target = readlink($this->getPath());

        if (!is_string($target) || ($target == $this->getPath())) {
            $this->giThrowNotFoundException('Target for symlink', $this->getPath());
        }

        $file    = $this->getFactory()->createFile($target);
        $dir     = $this->getFactory()->createDir($target);
        $symlink = $this->getFactory()->createSymlink($target);

        if ($file->isFile()) {
            $result = $file;
        } elseif ($dir->isDir()) {
            $result = $dir;
        } elseif ($symlink->isLink()) {
            $result = $symlink;
        } else {
            $result = null;
            $this->giThrowInvalidTypeException('Target for symlink', $target, 'File system object');
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isTargetReal()
    {
        try {
            $result = ($this->getRealTarget()->getPath() == $this->getTarget()->getPath());
        } catch (\Exception $exception) {
            $result = false;
        }

        return $result;
    }

    /**
     * @return static
     */
    public function setTargetToReal()
    {
        try {
            $this->setTarget($this->getRealTarget());
        } catch (\Exception $exception) {
            $this->setTarget();
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasTarget()
    {
        return ($this->target instanceof FSOInterface);
    }

    /**
     * @return FSOInterface
     * @throws \Exception
     */
    public function getTarget()
    {
        if (!$this->hasTarget()) {
            $this->giThrowNotSetException('Symlink target');
        }

        return $this->target;
    }

    /**
     * @param FSOInterface|null $target
     * @return static
     */
    public function setTarget(FSOInterface $target = null)
    {
        $this->target = $target;

        return $this;
    }


    /**
     * @return static
     * @throws \Exception
     */
    public function create()
    {
        if (!$this->isTargetReal()) {
            $this->getTarget()->fireInexistence();

            if ($this->exists()) {
                $this->delete();
            } else {
                $parent = $this->createParent();

                if (!$parent->exists()) {
                    $parent->setMode($this->getMode())->create();
                }
            }

            symlink($this->getTarget()->getPath(), $this->getPath());
        }

        return $this;
    }

    /**
     * @return static
     */
    public function delete()
    {
        if ($this->exists()) {
            unlink($this->getPath());
        }

        return $this;
    }

    /**
     * @param SymlinkInterface $symlink
     * @return static
     * @throws \Exception
     */
    public function makeCopy(SymlinkInterface $symlink)
    {
        $this->fireInexistence();

        copy($this->getPath(), $symlink->getPath());

        return $this;
    }

    /**
     * @param SymlinkInterface $symlink
     * @return static
     * @throws \Exception
     */
    public function move(SymlinkInterface $symlink)
    {
        $this->fireInexistence();

        rename($this->getPath(), $symlink->getPath());

        return $this;
    }

    /**
     * @return bool
     */
    public function isLink()
    {
        return is_link($this->getPath());
    }
}