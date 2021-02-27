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
namespace GI\Storage\Collection\ClosureCollection\ArrayList\Immutable;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Storage\Collection\ClosureCollection\CollectionTrait;

class Immutable implements ImmutableInterface
{
    use ServiceLocatorAwareTrait, CollectionTrait;


    /**
     * Immutable constructor.
     * @param \Closure[] $items
     */
    public function __construct(array $items = [])
    {
        $this->setItems($items);
    }

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return array_key_exists($index, $this->items);
    }

    /**
     * @param int $index
     * @return \Closure
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
     * @param int $index
     * @param string|mixed $default
     * @return \Closure|mixed
     */
    public function getOptional(int $index, $default = null)
    {
        try {
            $result = $this->get($index);
        } catch (\Exception $exception) {
            $result = $default;
        }

        return $result;
    }

    /**
     * @return \Closure
     * @throws \Exception
     */
    public function getFirst()
    {
        return $this->get(0);
    }

    /**
     * @return \Closure
     * @throws \Exception
     */
    public function getLast()
    {
        return $this->get($this->getLength() - 1);
    }

    /**
     * @param \Closure $item
     * @param int|null $position
     * @return static
     */
    protected function add(\Closure $item, int $position = null)
    {
        if (is_int($position) && $this->has($position)) {
            array_splice($this->items, $position, 0, [$item]);
        } else {
            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * @param \Closure[] $items
     * @param int|null $position
     * @return static
     */
    protected function apply(array $items, int $position = null)
    {
        foreach ($items as $item) {
            $this->add($item, $position);

            if (is_int($position)) {
                $position += 1;
            }
        }

        return $this;
    }

    /**
     * @param \Closure[] $items
     * @return static
     */
    protected function setItems(array $items)
    {
        $this->clean()->apply($items);

        return $this;
    }

    /**
     * @param ImmutableInterface $collection
     * @return static
     */
    protected function merge(ImmutableInterface $collection)
    {
        $this->apply($collection->getItems());

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
     * @return bool
     */
    protected function pop()
    {
        return $this->remove($this->getLength() - 1);
    }

    /**
     * @param int $index
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function execute(int $index, array $arguments = [])
    {
        return call_user_func_array($this->get($index), $arguments);
    }
}