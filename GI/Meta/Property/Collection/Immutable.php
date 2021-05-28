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
namespace GI\Meta\Property\Collection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\Property\PropertyInterface;

class Immutable implements ImmutableInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var PropertyInterface[]
     */
    private $items = [];


    /**
     * ImmutableHashSet constructor.
     * @param PropertyInterface[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->_set($item);
        }
    }

    /**
     * @param string $property
     * @return bool
     */
    public function has(string $property)
    {
        return isset($this->items[$property]);
    }

    /**
     * @param string $property
     * @return PropertyInterface
     * @throws \Exception
     */
    public function get(string $property)
    {
        if (!$this->has($property)) {
            $this->getGiServiceLocator()->throwNotInScopeException($property);
        }

        return $this->items[$property];
    }

    /**
     * @return PropertyInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        reset($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return PropertyInterface
     * @throws \Exception
     */
    public function getLast()
    {
        end($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return PropertyInterface[]
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
     * @return PropertyInterface[]
     */
    public function filter(\Closure $closure)
    {
        return array_filter($this->items, $closure);
    }

    /**
     * @param string $descriptor
     * @return PropertyInterface[]
     */
    public function findByDescriptorName(string $descriptor)
    {
        $f = function(PropertyInterface $property) use ($descriptor)
        {
            return $property->hasDescriptor($descriptor);
        };

        return $this->filter($f);
    }

    /**
     * @param string $descriptor
     * @return PropertyInterface
     * @throws \Exception
     */
    public function findOneByDescriptorName(string $descriptor)
    {
        $items = $this->findByDescriptorName($descriptor);

        if (empty($items)) {
            $this->getGiServiceLocator()->throwNotFoundException('Property with descriptor', [$descriptor]);
        }

        return array_shift($items);
    }

    /**
     * @param string $descriptor
     * @param mixed $value
     * @return PropertyInterface[]
     */
    public function findByDescriptorValue(string $descriptor, $value)
    {
        $f = function(PropertyInterface $property) use ($descriptor, $value)
        {
            return $property->hasDescriptor($descriptor) && ($property->getDescriptor($descriptor) == $value);
        };

        return $this->filter($f);
    }

    /**
     * @param string $descriptor
     * @param mixed $value
     * @return PropertyInterface
     * @throws \Exception
     */
    public function findOneByDescriptorValue(string $descriptor, $value)
    {
        $items = $this->findByDescriptorValue($descriptor, $value);

        if (empty($items)) {
            $this->getGiServiceLocator()->throwCommonException(
                'Property with descriptor \'%s\' and value \'%s\' not found', [$descriptor, $value]
            );
        }

        return array_shift($items);
    }

    /**
     * @param PropertyInterface $property
     * @return static
     */
    protected function _set(PropertyInterface $property)
    {
        $this->items[$property->getName()] = $property;

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