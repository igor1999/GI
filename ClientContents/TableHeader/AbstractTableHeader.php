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
namespace GI\ClientContents\TableHeader;

use GI\ClientContents\TableHeader\Column\Column;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\TableHeader\Column\ColumnInterface;

abstract class AbstractTableHeader implements TableHeaderInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ColumnInterface[]
     */
    private $items = [];


    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return isset($this->items[$index]);
    }

    /**
     * @param int $index
     * @return ColumnInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->giThrowNotInScopeException($index);
        }

        return $this->items[$index];
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
     * @param string $id
     * @param string $caption
     * @return ColumnInterface
     * @throws \Exception
     */
    protected function createColumn(string $id, string $caption)
    {
        try {
            $result = $this->giGetDi(ColumnInterface::class, null, [$id, $caption]);
        } catch (\Exception $e) {
            $result = new Column($id, $caption);
        }

        return $result;
    }

    /**
     * @param string $id
     * @param string $caption
     * @param bool $dataAttribute
     * @param bool $orderCriteria
     * @param bool $bothDirections
     * @return static
     * @throws \Exception
     */
    protected function add(
        string $id, string $caption,
        bool $dataAttribute = false, bool $orderCriteria = false, bool $bothDirections = false)
    {
        $column = $this->createColumn($id, $caption);

        $this->items[] = $column;

        if ($dataAttribute) {
            $column->createDataSource()->getDataSource()->setDataAttribute($id)->setTypeToDataAttribute();
        }

        if ($orderCriteria) {
            $column->createOrder()->getOrder()->setCriteria($id)->setBothDirections($bothDirections);
        }

        return $this;
    }

    /**
     * @param string $id
     * @param string $caption
     * @return static
     * @throws \Exception
     */
    protected function addWithDataAttribute(string $id, string $caption)
    {
        $this->add($id, $caption, true);

        return $this;
    }

    /**
     * @param string $id
     * @param string $caption
     * @return static
     * @throws \Exception
     */
    protected function addWithDataAttributeAndOrderAscendant(string $id, string $caption)
    {
        $this->add($id, $caption, true, true);

        return $this;
    }

    /**
     * @param string $id
     * @param string $caption
     * @return static
     * @throws \Exception
     */
    protected function addWithDataAttributeAndOrderComplete(string $id, string $caption)
    {
        $this->add($id, $caption, true, true, true);

        return $this;
    }

    /**
     * @param string $id
     * @param string $caption
     * @return static
     * @throws \Exception
     */
    protected function addWithOrderAscendant(string $id, string $caption)
    {
        $this->add($id, $caption, false, true);

        return $this;
    }

    /**
     * @param string $id
     * @param string $caption
     * @return static
     * @throws \Exception
     */
    protected function addWithOrderComplete(string $id, string $caption)
    {
        $this->add($id, $caption, false, true, true);

        return $this;
    }

    /**
     * @param string $id
     * @param string $caption
     * @return $this
     * @throws \Exception
     */
    protected function addWithRowNumber(string $id, string $caption)
    {
        $this->add($id, $caption);

        $this->items[$this->getLength() - 1]->createDataSource()->getDataSource()->setTypeToRowNumber();

        return $this;
    }

    /**
     * @param int $index
     * @param string $id
     * @param string $caption
     * @return static
     * @throws \Exception
     */
    protected function insert(int $index, string $id, string $caption)
    {
        if ($this->has($index)) {
            array_splice($this->items, $index, 0, [$this->createColumn($id, $caption)]);
        } else {
            $this->add($id, $caption);
        }

        return $this;
    }

    /**
     * @param int $index
     * @return bool
     */
    protected function remove(int $index)
    {
        if ($result = $this->has($index)) {
            array_splice($this->items, $index, 1);
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

    /**
     * @param string $orderAttribute
     * @return static
     */
    public function setOrder(string $orderAttribute)
    {
        foreach ($this->items as $column) {
            try {
                $column->getOrder()->setActualCriteria($orderAttribute);
            } catch (\Exception $e) {}
        }

        return $this;
    }

    /**
     * @param bool $direction
     * @return static
     */
    public function setDirection(bool $direction)
    {
        foreach ($this->items as $column) {
            try {
                $column->getOrder()->setActualDirection($direction);
            } catch (\Exception $e) {}
        }

        return $this;
    }

    /**
     * @param string $orderAttribute
     * @param bool $direction
     * @return static
     */
    public function setOrderAndDirection(string $orderAttribute, bool $direction)
    {
        $this->setOrder($orderAttribute)->setDirection($direction);

        return $this;
    }
}