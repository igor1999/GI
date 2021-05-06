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
namespace GI\Component\Table\View\Widget\Template\Collection;

use GI\Component\Table\View\Widget\Template\Column;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Component\Table\View\Widget\Template\ColumnInterface;

abstract class AbstractCollection implements CollectionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ColumnInterface[]
     */
    private $items = [];


    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id)
    {
        return isset($this->items[$id]);
    }

    /**
     * @param string $id
     * @return ColumnInterface
     * @throws \Exception
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            $this->giThrowNotInScopeException($id);
        }

        return $this->items[$id];
    }

    /**
     * @return ColumnInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param string $headerCellClass
     * @param string $bodyCellClass
     * @return ColumnInterface
     * @throws \Exception
     */
    protected function createColumn(string $headerCellClass, string $bodyCellClass)
    {
        try {
            $result = $this->giGetDi(ColumnInterface::class, null, [$headerCellClass, $bodyCellClass]);
        } catch (\Exception $exception) {
            $result = new Column($headerCellClass, $bodyCellClass);
        }

        return $result;
    }

    /**
     * @param string $id
     * @param string $headerCellClass
     * @param string $bodyCellClass
     * @return static
     * @throws \Exception
     */
    protected function set(string $id, string $headerCellClass, string $bodyCellClass)
    {
        $this->items[$id] = $this->createColumn($headerCellClass, $bodyCellClass);

        return $this;
    }

    /**
     * @param string $id
     * @param string $anchor
     * @param string $headerCellClass
     * @param string $bodyCellClass
     * @return static
     * @throws \Exception
     */
    protected function insertBefore(string $id, string $anchor, string $headerCellClass, string $bodyCellClass)
    {
        $position = array_search($anchor, array_keys($this->items));

        if ($position === false) {
            $this->set($id, $headerCellClass, $bodyCellClass);
        } else {
            $before = array_slice($this->items, 0, $position);
            $after  = array_slice($this->items, $position);

            $this->items = array_merge($before, [$id => $this->createColumn($headerCellClass, $bodyCellClass)], $after);
        }

        return $this;
    }

    /**
     * @param string $id
     * @return bool
     */
    protected function remove(string $id)
    {
        if ($result = $this->has($id)) {
            unset($this->items[$id]);
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function clean()
    {
        $this->items = [];

        return $this;
    }
}