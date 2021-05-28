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
namespace GI\Meta\ClassMeta\Collection;

use GI\Meta\ClassMeta\ClassMeta;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\ClassMeta\ClassMetaInterface;

class Immutable implements ImmutableInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ClassMetaInterface[]
     */
    private $items = [];


    /**
     * ImmutableHashSet constructor.
     * @param ClassMetaInterface[]|string[] $items
     * @throws \Exception
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            if ($item instanceof ClassMetaInterface) {
                $this->_set($item);
            } else {
                $this->_setByName($item);
            }
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->getGiServiceLocator()->throwNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        reset($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function getLast()
    {
        end($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return ClassMetaInterface[]
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
     * @param \Closure $filter
     * @return ClassMetaInterface[]
     */
    public function filter(\Closure $filter)
    {
        return array_filter($this->items, $filter);
    }

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findParents(ClassMetaInterface $class)
    {
        $f = function(ClassMetaInterface $item) use ($class)
        {
            return ($class->getParent()!== false) && ($item->getName() == $class->getParent()->getName());
        };

        return $this->filter($f);
    }

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findChildren(ClassMetaInterface $class)
    {
        $f = function(ClassMetaInterface $item) use ($class)
        {
            return ($item->getParent()!== false) && ($item->getParent()->getName() == $class->getName());
        };

        return $this->filter($f);
    }

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findDescendants(ClassMetaInterface $class)
    {
        $f = function(ClassMetaInterface $item) use ($class)
        {
            return is_subclass_of($class->getName(), $item->getName(), true);
        };

        return $this->filter($f);
    }

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findAscendants(ClassMetaInterface $class)
    {
        $f = function(ClassMetaInterface $item) use ($class)
        {
            return is_subclass_of($item->getName(), $class->getName(), true);
        };

        return $this->filter($f);
    }

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findImplementations(ClassMetaInterface $class)
    {
        $f = function(ClassMetaInterface $item) use ($class)
        {
            return is_a($item->getName(), $class->getName(), true);
        };

        return $this->filter($f);
    }

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findByImplementation(ClassMetaInterface $class)
    {
        $f = function(ClassMetaInterface $item) use ($class)
        {
            return is_a($class->getName(), $item->getName(), true);
        };

        return $this->filter($f);
    }

    /**
     * @return ClassMetaInterface[]
     */
    public function findClasses()
    {
        $f = function(ClassMetaInterface $item)
        {
            return !$item->getReflection()->isTrait() && !$item->getReflection()->isInterface();
        };

        return $this->filter($f);
    }

    /**
     * @return ClassMetaInterface[]
     */
    public function findAbstractClasses()
    {
        $f = function(ClassMetaInterface $item)
        {
            return $item->getReflection()->isAbstract();
        };

        return $this->filter($f);
    }

    /**
     * @return ClassMetaInterface[]
     */
    public function findTraits()
    {
        $f = function(ClassMetaInterface $item)
        {
            return $item->getReflection()->isTrait();
        };

        return $this->filter($f);
    }

    /**
     * @return ClassMetaInterface[]
     */
    public function findInterfaces()
    {
        $f = function(ClassMetaInterface $item)
        {
            return $item->getReflection()->isInterface();
        };

        return $this->filter($f);
    }

    /**
     * @param ClassMetaInterface $item
     * @return static
     */
    protected function _set(ClassMetaInterface $item)
    {
        $this->items[$item->getName()] = $item;

        return $this;
    }

    /**
     * @param string $class
     * @return static
     * @throws \Exception
     */
    protected function _setByName(string $class)
    {
        $this->_set($this->createClassMeta($class));

        return $this;
    }

    /**
     * @param string $class
     * @return ClassMeta
     * @throws \Exception
     */
    protected function createClassMeta(string $class)
    {
        return new ClassMeta($class);
    }

    /**
     * @param ImmutableInterface $hashSet
     * @return static
     */
    protected function _merge(ImmutableInterface $hashSet)
    {
        $this->items = array_merge($this->items, $hashSet->getItems());

        return $this;
    }

    /**
     * @param string $class
     * @return bool
     */
    protected function _remove(string $class)
    {
        if ($result = $this->has($class)) {
            unset($this->items[$class]);
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