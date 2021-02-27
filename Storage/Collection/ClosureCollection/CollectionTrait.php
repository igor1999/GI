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
namespace GI\Storage\Collection\ClosureCollection;

use GI\Storage\Collection\CollectionTrait as BaseTrait;

trait CollectionTrait
{
    use BaseTrait;


    /**
     * @var \Closure[]
     */
    private $items = [];


    /**
     * @return \Closure[]
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
     * @return int
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param \Closure[] $items
     * @return static
     */
    abstract protected function setItems(array $items);

    /**
     * @param \Closure $value
     * @return static
     */
    protected function reset(\Closure $value)
    {
        if (!$this->isEmpty()) {
            $items = array_fill(0, $this->getLength() - 1, $value);
            $keys = array_keys($this->items);

            $items = array_combine($keys, $items);
            $this->setItems($items);
        }

        return $this;
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
     * @param array $arguments
     * @return array
     */
    public function executeParallel(array $arguments = [])
    {
        $f = function(\Closure $item) use ($arguments)
        {
            return call_user_func_array($item, $arguments);
        };

        return array_map($f, $this->items);
    }

    /**
     * @param array $arguments
     * @return static
     */
    public function executeSequentially(array $arguments = [])
    {
        foreach ($this->items as $item) {
            if (!call_user_func_array($item, $arguments)) {
                break;
            }
        }

        return $this;
    }
}