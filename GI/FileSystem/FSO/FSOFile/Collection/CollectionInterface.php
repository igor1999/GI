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
namespace GI\FileSystem\FSO\FSOFile\Collection;

use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

interface CollectionInterface
{
    /**
     * @param FSOFileInterface $file
     * @return FSOFileInterface[]
     */
    public function find(FSOFileInterface $file);

    /**
     * @return FSOFileInterface[]
     */
    public function findExistent();

    /**
     * @return FSOFileInterface[]
     */
    public function findInexistent();

    /**
     * @param \Closure $filter
     * @return FSOFileInterface[]
     */
    public function filter(\Closure $filter);

    /**
     * @return FSOFileInterface[]
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