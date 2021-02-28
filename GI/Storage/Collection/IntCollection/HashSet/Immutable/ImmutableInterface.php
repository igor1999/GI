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
namespace GI\Storage\Collection\IntCollection\HashSet\Immutable;

use GI\Storage\Collection\IntCollection\CollectionInterface;
use GI\Storage\Collection\Behaviour\Service\IntCollection\HashSet\HashSetInterface as ServiceInterface;

interface ImmutableInterface extends CollectionInterface
{
    /**
     * @return ServiceInterface
     */
    public function getService();

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return int
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param int|mixed $default
     * @return int|mixed
     */
    public function getOptional(string $key, $default = 0);

    /**
     * @param int $position
     * @return bool
     */
    public function hasPosition(int $position);

    /**
     * @param int $position
     * @return string
     * @throws \Exception
     */
    public function getKeyByPosition(int $position);

    /**
     * @param int $position
     * @return int
     * @throws \Exception
     */
    public function getByPosition(int $position);

    /**
     * @return int
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param string $key
     * @return int
     * @throws \Exception
     */
    public function findPositionOfKey(string $key);

    /**
     * @param int $item
     * @return int
     * @throws \Exception
     */
    public function findPositionOfItem(int $item);

    /**
     * @param string $key
     * @param int $distance
     * @return string
     * @throws \Exception
     */
    public function getNextKey(string $key, int $distance = 1);

    /**
     * @param string $key
     * @param int $distance
     * @return int
     * @throws \Exception
     */
    public function getNextItem(string $key, int $distance = 1);
}