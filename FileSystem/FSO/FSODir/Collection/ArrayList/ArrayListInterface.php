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
namespace GI\FileSystem\FSO\FSODir\Collection\ArrayList;

use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSODir\Collection\CollectionInterface as FSODirCollectionInterface;

interface ArrayListInterface extends  FSODirCollectionInterface
{
    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return FSODirInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @param FSODirInterface $dir
     * @return static
     */
    public function add(FSODirInterface $dir);

    /**
     * @param int $index
     * @param FSODirInterface $dir
     * @return static
     */
    public function insert(int $index, FSODirInterface $dir);

    /**
     * @param int $index
     * @param FSODirInterface $fso
     * @return static
     * @throws \Exception
     */
    public function set(int $index, FSODirInterface $fso);

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index);
}