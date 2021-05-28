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
namespace GI\RDB\SQL\Builder\Condition;

use GI\RDB\SQL\Builder\Condition\Cortege\Cortege as CortegeCondition;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\SQL\Builder\BuilderInterface;
use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\AlterableInterface;
use GI\RDB\SQL\Cortege\Predicates\PredicatesInterface;
use GI\RDB\SQL\Builder\Condition\Cortege\CortegeInterface as CortegeConditionInterface;

class ConditionList implements ConditionListInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @var AlterableInterface
     */
    private $params;

    /**
     * @var bool
     */
    private $alt = true;

    /**
     * @var ConditionInterface[]
     */
    private $items = [];


    /**
     * Params constructor.
     * @param BuilderInterface $builder
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return BuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @return AlterableInterface
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return static
     */
    public function setParams(array $params)
    {
        $this->params = $this->getGiServiceLocator()->getStorageFactory()->createScalarHashSetAlterable($params);

        return $this;
    }

    /**
     * @return bool
     */
    public function isAlt()
    {
        return $this->alt;
    }

    /**
     * @param bool $alt
     * @return static
     */
    public function setAlt(bool $alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param string $key
     * @return ConditionInterface
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
     * @return ConditionInterface[]
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
     * @param string $placeholder
     * @param ConditionInterface $predicate
     * @return static
     */
    public function set(string $placeholder, ConditionInterface $predicate)
    {
        $this->items[$placeholder] = $predicate;

         return $this;
   }

    /**
     * @param string $placeholder
     * @param string $predicate
     * @param \Closure|null $validator
     * @param bool|null $alt
     * @return static
     */
    public function setByContents(string $placeholder, string $predicate, \Closure $validator = null, bool $alt = null)
    {
        $this->set($placeholder, $this->createCondition($placeholder, $predicate, $validator, $alt));

        return $this;
    }

    /**
     * @param string $placeholder
     * @param string $predicate
     * @param \Closure|null $validator
     * @param bool|null $alt
     * @return ConditionInterface
     */
    protected function createCondition(string $placeholder, string $predicate, \Closure $validator = null, bool $alt = null)
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(
                ConditionInterface::class, null, [$this, $placeholder, $predicate, $validator, $alt]
            );
        } catch (\Exception $e) {
            $result = new Condition($this, $placeholder, $predicate, $validator, $alt);
        }

        return $result;
    }

    /**
     * @param string $placeholder
     * @param PredicatesInterface $predicates
     * @param bool|null $alt
     * @return static
     * @throws \Exception
     */
    public function setCortegeConditionByContents(
        string $placeholder, PredicatesInterface $predicates, bool $alt = null)
    {
        $this->set($placeholder, $this->createCortegeCondition($placeholder, $predicates, $alt));

        return $this;
    }

    /**
     * @param string $placeholder
     * @param PredicatesInterface $predicates
     * @param bool|null $alt
     * @return CortegeConditionInterface
     * @throws \Exception
     */
    protected function createCortegeCondition(string $placeholder, PredicatesInterface $predicates, bool $alt = null)
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(
                CortegeConditionInterface::class, null, [$this, $placeholder, $predicates, $alt]
            );
        } catch (\Exception $e) {
            $result = new CortegeCondition($this, $placeholder, $predicates, $alt);
        }

        return $result;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key)
    {
        if ($result = $this->has($key)) {
            unset($this->items[$key]);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @return static
     */
    public function build()
    {
        foreach ($this->getItems() as $item) {
            $item->build();
        }

        return $this;
    }
}