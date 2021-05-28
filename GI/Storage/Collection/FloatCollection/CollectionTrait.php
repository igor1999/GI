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
namespace GI\Storage\Collection\FloatCollection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Storage\Collection\CollectionTrait as BaseTrait;

trait CollectionTrait
{
    use BaseTrait;


    /**
     * @var float[]
     */
    private $items = [];


    /**
     * @return float[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return float[]
     */
    public function extract()
    {
        return $this->getItems();
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return int
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param float $needle
     * @return array
     */
    public function find(float $needle)
    {
        $f = function($item) use ($needle)
        {
            return $item === $needle;
        };

        return array_keys(array_filter($this->items, $f));
    }

    /**
     * @param float $needle
     * @return mixed
     * @throws \Exception
     */
    public function findOne(float $needle)
    {
        $found = $this->find($needle);

        if (empty($found)) {
            /** @var ServiceLocatorAwareTrait $me */
            $me = $this;
            $me->getGiServiceLocator()->throwNotFoundException('Element of collection');
        }

        return array_shift($found);
    }

    /**
     * @param float $needle
     * @return bool
     */
    public function contains(float $needle)
    {
        return !empty($this->find($needle));
    }

    /**
     * @param \Closure $filter
     * @return float[]
     */
    public function findByClosure(\Closure $filter)
    {
        return array_filter($this->items, $filter);
    }

    /**
     * @param \Closure $filter
     * @return float
     * @throws \Exception
     */
    public function findOneByClosure(\Closure $filter)
    {
        $found = $this->findByClosure($filter);

        if (empty($found)) {
            /** @var ServiceLocatorAwareTrait $me */
            $me = $this;
            $me->getGiServiceLocator()->throwNotFoundException('Element of collection');
        }

        return array_shift($found);
    }

    /**
     * @param \Closure $filter
     * @return bool
     */
    public function containsByClosure(\Closure $filter)
    {
        return !empty($this->findByClosure($filter));
    }

    /**
     * @param string[] $items
     * @return static
     */
    abstract protected function setItems(array $items);

    /**
     * @param \Closure $f
     * @return static
     */
    protected function filter(\Closure $f)
    {
        $this->setItems(array_filter($this->items, $f));

        return $this;
    }

    /**
     * @param \Closure $f
     * @return static
     */
    protected function map(\Closure $f)
    {
        $values = array_map($f, $this->items, array_keys($this->items));
        $items  = array_combine(array_keys($this->items), $values);

        $this->setItems($items);

        return $this;
    }

    /**
     * @param float $value
     * @return static
     */
    protected function reset(float $value = 0.0)
    {
        $f = function() use ($value)
        {
            return $value;
        };

        return $this->map($f);
    }

    /**
     * @return float
     */
    public function sum()
    {
        $f = function(float $carry, float $item)
        {
            return $carry + $item;
        };

        return array_reduce($this->items, $f, 0);
    }

    /**
     * @return float
     */
    public function product()
    {
        $f = function(float $carry, float $item)
        {
            return $carry * $item;
        };

        return array_reduce($this->items, $f, 1);
    }

    /**
     * @param \Closure $pairGlue
     * @return array
     */
    public function getPairsWithClosure(\Closure $pairGlue)
    {
        return array_map($pairGlue, $this->items, array_keys($this->items));
    }

    /**
     * @param string $pairGlue
     * @return array
     */
    public function getPairs(string $pairGlue = self::DEFAULT_PAIR_GLUE)
    {
        $f = function(float $value, $key) use ($pairGlue)
        {
            return $key . $pairGlue . (string)$value;
        };

        return $this->getPairsWithClosure($f);
    }

    /**
     * @param string $itemGlue
     * @param \Closure $pairGlue
     * @return string
     */
    public function joinPairsWithClosure(string $itemGlue, \Closure $pairGlue)
    {
        return implode($itemGlue, $this->getPairsWithClosure($pairGlue));
    }

    /**
     * @param string $itemGlue
     * @param string $pairGlue
     * @return string
     */
    public function joinPairs(string $itemGlue, string $pairGlue = self::DEFAULT_PAIR_GLUE)
    {
        return implode($itemGlue, $this->getPairs($pairGlue));
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
     * @return bool[]
     */
    public function getItemsAsBool()
    {
        $f = function($item)
        {
            return !empty($item);
        };

        return array_map($f, $this->items);
    }

    /**
     * @return int[]
     */
    public function getItemsAsInt()
    {
        $f = function($item)
        {
            return (int)$item;
        };

        return array_map($f, $this->items);
    }

    /**
     * @return string[]
     */
    public function getItemsAsString()
    {
        $f = function($item)
        {
            return (string)$item;
        };

        return array_map($f, $this->items);
    }
}