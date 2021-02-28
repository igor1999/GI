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
namespace GI\Storage\Collection\StringCollection\ArrayList\Alterable;

use GI\Storage\Collection\StringCollection\ArrayList\Immutable\Immutable;

use GI\Storage\Collection\StringCollection\ArrayList\Immutable\ImmutableInterface;

class Alterable extends Immutable implements AlterableInterface
{
    /**
     * @param string $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function add(string $item, int $position = null)
    {
        return parent::add($item);
    }

    /**
     * @param string[] $items
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function apply(array $items, int $position = null)
    {
        return parent::apply($items);
    }

    /**
     * @param string[] $items
     * @return static
     * @throws \Exception
     */
    public function setItems(array $items)
    {
        return parent::setItems($items);
    }

    /**
     * @param ImmutableInterface $collection
     * @return static
     * @throws \Exception
     */
    public function merge(ImmutableInterface $collection)
    {
        return parent::merge($collection);
    }

    /**
     * @param string[] $items
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $items)
    {
        return $this->setItems($items);
    }

    /**
     * @param \Closure $f
     * @return static
     * @throws \Exception
     */
    public function filter(\Closure $f)
    {
        return parent::filter($f);
    }

    /**
     * @param \Closure $f
     * @return static
     * @throws \Exception
     */
    public function map(\Closure $f)
    {
        return parent::map($f);
    }

    /**
     * @param string $value
     * @return static
     * @throws \Exception
     */
    public function reset(string $value = '')
    {
        return parent::reset($value);
    }

    /**
     * @param string $source
     * @param string $itemGlue
     * @return static
     * @throws \Exception
     */
    public function read(string $source, string $itemGlue)
    {
        return parent::read($source, $itemGlue);
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index)
    {
        return parent::remove($index);
    }

    /**
     * @return bool
     */
    public function pop()
    {
        return parent::pop();
    }

    /**
     * @param string $needle
     * @return bool
     */
    public function removeItem(string $needle)
    {
        return parent::removeItem($needle);
    }

    /**
     * @return static
     */
    public function clean()
    {
        return parent::clean();
    }
}