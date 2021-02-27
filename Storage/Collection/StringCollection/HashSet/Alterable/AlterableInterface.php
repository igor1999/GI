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
namespace GI\Storage\Collection\StringCollection\HashSet\Alterable;

use GI\Storage\Collection\StringCollection\HashSet\Immutable\ImmutableInterface;
use GI\Pattern\ArrayExchange\HydrationInterface;

interface AlterableInterface extends ImmutableInterface, HydrationInterface
{
    /**
     * @param string $key
     * @param string $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function set(string $key, string $item, int $position = null);

    /**
     * @param string $key
     * @param string $anchor
     * @param string $item
     * @return static
     * @throws \Exception
     */
    public function insertBefore(string $key, string $anchor, string $item);

    /**
     * @param string[] $items
     * @return static
     * @throws \Exception
     */
    public function apply(array $items);

    /**
     * @param string[] $items
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
     * @param string[] $items
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
     * @param string $value
     * @return static
     * @throws \Exception
     */
    public function reset(string $value = '');

    /**
     * @param string $source
     * @param string $itemGlue
     * @param string $pairGlue
     * @return static
     * @throws \Exception
     */
    public function read(string $source, string $itemGlue, string $pairGlue = self::DEFAULT_PAIR_GLUE);

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key);

    /**
     * @param string $needle
     * @return bool
     */
    public function removeItem(string $needle);

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