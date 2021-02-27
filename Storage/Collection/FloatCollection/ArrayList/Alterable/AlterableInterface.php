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
namespace GI\Storage\Collection\FloatCollection\ArrayList\Alterable;

use GI\Storage\Collection\FloatCollection\ArrayList\Immutable\ImmutableInterface;
use GI\Pattern\ArrayExchange\HydrationInterface;

interface AlterableInterface extends ImmutableInterface, HydrationInterface
{
    /**
     * @param float $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function add(float $item, int $position = null);

    /**
     * @param float[] $items
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function apply(array $items, int $position = null);

    /**
     * @param float[] $items
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
     * @param float[] $items
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $items);

    /**
     * @param \Closure $f
     * @return static
     * @throws \Exception
     */
    public function filter(\Closure $f);

    /**
     * @param \Closure $f
     * @return static
     * @throws \Exception
     */
    public function map(\Closure $f);

    /**
     * @param float $value
     * @return static
     * @throws \Exception
     */
    public function reset(float $value = 0.0);

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
     * @param float $needle
     * @return bool
     */
    public function removeItem(float $needle);

    /**
     * @return static
     */
    public function clean();
}