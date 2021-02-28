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

use GI\FileSystem\FSO\FSOInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\FSO\Symlink\SymlinkInterface;
use GI\FileSystem\FSO\FSODir\Behaviour\ChildrenInterface;
use GI\FileSystem\FSO\FSODir\Behaviour\NodesInterface;

interface FSODirInterface extends FSOInterface
{
    /**
     * @param string $path
     * @return FSODirInterface
     */
    public function createChildDir(string $path);

    /**
     * @param string $path
     * @return FSOFileInterface
     */
    public function createChildFile(string $path);

    /**
     * @param string $path
     * @return SymlinkInterface
     */
    public function createChildSymlink(string $path);

    /**
     * @return static
     * @throws \Exception
     */
    public function delete();

    /**
     * @param FSODirInterface $dir
     * @return static
     * @throws \Exception
     */
    public function makeCopy(FSODirInterface $dir);

    /**
     * @param FSODirInterface $dir
     * @return static
     * @throws \Exception
     */
    public function move(FSODirInterface $dir);

    /**
     * @return bool
     */
    public function isDir();

    /**
     * @return ChildrenInterface
     * @throws \Exception
     */
    public function getChildren();

    /**
     * @return NodesInterface
     * @throws \Exception
     */
    public function getNodes();
}