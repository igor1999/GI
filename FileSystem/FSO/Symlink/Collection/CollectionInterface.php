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
namespace GI\FileSystem\FSO\Symlink\Collection;

use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\Symlink\SymlinkInterface;

interface CollectionInterface
{
    /**
     * @param SymlinkInterface $symlink
     * @return SymlinkInterface[]
     */
    public function find(SymlinkInterface $symlink);

    /**
     * @return SymlinkInterface[]
     */
    public function findExistent();

    /**
     * @return SymlinkInterface[]
     */
    public function findInexistent();

    /**
     * @param \Closure $filter
     * @return SymlinkInterface[]
     */
    public function filter(\Closure $filter);

    /**
     * @return SymlinkInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @return static
     */
    public function clean();

    /**
     * @param FSODirInterface $dir
     * @return static
     * @throws \Exception
     */
    public function makeCopy(FSODirInterface $dir);

    /**
     * @return static
     */
    public function delete();
}