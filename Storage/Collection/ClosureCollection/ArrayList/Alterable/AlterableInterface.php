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
namespace GI\Storage\Collection\ClosureCollection\ArrayList\Alterable;

use GI\Storage\Collection\ClosureCollection\ArrayList\Immutable\ImmutableInterface;

interface AlterableInterface extends ImmutableInterface
{
    /**
     * @param \Closure $item
     * @param int|null $position
     * @return static
     */
    public function add(\Closure $item, int $position = null);

    /**
     * @param \Closure[] $items
     * @param int|null $position
     * @return static
     */
    public function apply(array $items, int $position = null);

    /**
     * @param \Closure[] $items
     * @return static
     */
    public function setItems(array $items);

    /**
     * @param ImmutableInterface $collection
     * @return static
     */
    public function merge(ImmutableInterface $collection);

    /**
     * @param \Closure $value
     * @return static
     * @throws \Exception
     */
    public function reset(\Closure $value);

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index);

    /**
     * @return bool
     */
    public function pop();

    /**
     * @return static
     */
    public function clean();
}