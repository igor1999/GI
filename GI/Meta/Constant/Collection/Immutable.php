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
namespace GI\Meta\Constant\Collection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\Constant\ConstantInterface;

class Immutable implements ImmutableInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ConstantInterface[]
     */
    private $items = [];


    /**
     * ImmutableHashSet constructor.
     * @param ConstantInterface[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->_set($item);
        }
    }

    /**
     * @param string $constant
     * @return bool
     */
    public function has(string $constant)
    {
        return isset($this->items[$constant]);
    }

    /**
     * @param string $constant
     * @return ConstantInterface
     * @throws \Exception
     */
    public function get(string $constant)
    {
        if (!$this->has($constant)) {
            $this->getGiServiceLocator()->throwNotInScopeException($constant);
        }

        return $this->items[$constant];
    }

    /**
     * @return ConstantInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        reset($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return ConstantInterface
     * @throws \Exception
     */
    public function getLast()
    {
        end($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return ConstantInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return bool
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
     * @param \Closure $closure
     * @return ConstantInterface[]
     */
    public function filter(\Closure $closure)
    {
        return array_filter($this->items, $closure);
    }

    /**
     * @param ConstantInterface $constant
     * @return static
     */
    protected function _set(ConstantInterface $constant)
    {
        $this->items[$constant->getName()] = $constant;

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function _remove(string $name)
    {
        if ($result = $this->has($name)) {
            unset($this->items[$name]);
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function _clean()
    {
        $this->items = [];

        return $this;
    }
}