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
namespace GI\ServiceLocator\AwareTraits;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\FileSystem\Factory\FactoryInterface as FileSystemFactoryInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\FSO\Symlink\URLHolder\URLHolderInterface;

trait FileSystemAwareTrait
{
    /**
     * @return FileSystemFactoryInterface
     */
    protected function giGetFileSystemFactory()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getFileSystemFactory(static::class);
    }

    /**
     * @param string $path
     * @return FSODirInterface
     */
    protected function giCreateFSODir(string $path)
    {
        return $this->giGetFileSystemFactory()->createDir($path);
    }

    /**
     * @param string $path
     * @return FSOFileInterface
     */
    protected function giCreateFSOFile(string $path)
    {
        return $this->giGetFileSystemFactory()->createFile($path);
    }

    /**
     * @param string $class
     * @param string $childPath
     * @return FSODirInterface
     */
    protected function giCreateClassDirChildDir(string $class, string $childPath)
    {
        return $this->giGetFileSystemFactory()->createClassDir($class)->createChildDir($childPath);
    }

    /**
     * @param string $class
     * @param string $childPath
     * @return FSOFileInterface
     */
    protected function giCreateClassDirChildFile(string $class, string $childPath)
    {
        return $this->giGetFileSystemFactory()->createClassDir($class)->createChildFile($childPath);
    }

    /**
     * @param string $class
     * @param string $relativePathToTarget
     * @param string $relativeURL
     * @param bool $withCreate
     * @return URLHolderInterface
     * @throws \Exception
     */
    protected function giCreateURLHolderByClass(
        string $class, string $relativePathToTarget, string $relativeURL, bool $withCreate = true)
    {
        $target = $this->giCreateClassDirChildFile($class, $relativePathToTarget);
        $result = $this->giGetFileSystemFactory()->createURLHolder($target, $relativeURL);

        if ($withCreate) {
            $result->create();
        }

        return $result;
    }

    /**
     * @param FSODirInterface $targetBase
     * @param FSODirInterface $urlBase
     * @param string $relativePath
     * @param bool $withCreate
     * @return URLHolderInterface
     * @throws \Exception
     */
    protected function giCreateURLHolderByRelativePath(
        FSODirInterface $targetBase, FSODirInterface $urlBase, string $relativePath, bool $withCreate = true)
    {
        $target = $targetBase->createChildFile($relativePath);
        $url    = $urlBase->createChildFile($relativePath)->getPath();

        $result = $this->giGetFileSystemFactory()->createURLHolder($target, $url);

        if ($withCreate) {
            $result->create();
        }

        return $result;
    }
}