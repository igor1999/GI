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
namespace GI\ClientContents\TableOrdering\Collection;

use GI\ClientContents\TableOrdering\TableOrdering;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\TableOrdering\TableOrderingInterface;

abstract class AbstractCollection implements CollectionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var TableOrderingInterface[]
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
     * @return TableOrderingInterface
     * @throws \Exception
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            $this->getGiServiceLocator()->throwNotInScopeException($id);
        }

        return $this->items[$id];
    }

    /**
     * @return TableOrderingInterface[]
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
     * @param string $criteria
     * @param bool $bothDirections
     * @return TableOrderingInterface
     * @throws \Exception
     */
    protected function createHeader(string $criteria, bool $bothDirections)
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(TableOrderingInterface::class, null, [$criteria, $bothDirections]);
        } catch (\Exception $e) {
            $result = new TableOrdering($criteria, $bothDirections);
        }

        return $result;
    }

    /**
     * @param string $id
     * @param string $criteria
     * @param bool $bothDirections
     * @return static
     * @throws \Exception
     */
    protected function set(string $id, string $criteria, bool $bothDirections)
    {
        $this->items[$id] = $this->createHeader($criteria, $bothDirections);

        return $this;
    }

    /**
     * @param string $id
     * @param string $anchor
     * @param string $criteria
     * @param bool $bothDirections
     * @return static
     * @throws \Exception
     */
    protected function insertBefore(string $id, string $anchor, string $criteria, bool $bothDirections)
    {
        $position = array_search($anchor, array_keys($this->items));

        if ($position === false) {
            $this->set($id, $criteria, $bothDirections);
        } else {
            $before = array_slice($this->items, 0, $position);
            $after  = array_slice($this->items, $position);

            $this->items = array_merge($before, [$id => $this->createHeader($criteria, $bothDirections)], $after);
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

    /**
     * @param string $orderCriteria
     * @param bool $orderDirection
     * @return static
     */
    public function setOrdering(string $orderCriteria, bool $orderDirection)
    {
        foreach ($this->items as $item) {
            $item->setOrdering($orderCriteria, $orderDirection);
        }

        return $this;
    }
}