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
namespace GI\Storage\Collection\ClosureCollection\HashSet\Alterable;

use GI\Storage\Collection\ClosureCollection\HashSet\Immutable\ImmutableInterface;

interface AlterableInterface extends ImmutableInterface
{
    /**
     * @param string $key
     * @param \Closure $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function set(string $key, \Closure $item, int $position = null);

    /**
     * @param string $key
     * @param string $anchor
     * @param \Closure $item
     * @return static
     * @throws \Exception
     */
    public function insertBefore(string $key, string $anchor, \Closure $item);

    /**
     * @param \Closure[] $items
     * @return static
     * @throws \Exception
     */
    public function apply(array $items);

    /**
     * @param \Closure[] $items
     * @return static
     * @throws \Exception
     */
    public function setItems(array $items);

    /**
     * @param ImmutableInterface $collection
     * @return static
     * @throws \Exception
     */
    public function merge(ImmutableInterface $collection);

    /**
     * @param \Closure $value
     * @return static
     * @throws \Exception
     */
    public function reset(\Closure $value);

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key);

    /**
     * @param int $position
     * @return bool
     * @throws \Exception
     */
    public function removeByPosition(int $position);

    /**
     * @return bool
     * @throws \Exception
     */
    public function pop();

    /**
     * @return static
     */
    public function clean();
}