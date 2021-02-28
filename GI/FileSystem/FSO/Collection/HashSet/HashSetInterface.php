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
namespace GI\FileSystem\FSO\Collection\HashSet;

use GI\FileSystem\FSO\FSOInterface;
use GI\FileSystem\FSO\Collection\CollectionInterface as FSOCollectionInterface;

interface HashSetInterface extends  FSOCollectionInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return FSOInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return FSOInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return FSOInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param string $key
     * @param FSOInterface $fso
     * @return static
     */
    public function set(string $key, FSOInterface $fso);

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key);
}