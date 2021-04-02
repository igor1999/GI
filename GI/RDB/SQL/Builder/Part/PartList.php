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
namespace GI\RDB\SQL\Builder\Part;

use GI\RDB\SQL\Builder\Part\Group\Group;
use GI\RDB\SQL\Builder\Part\Limit\Limit;
use GI\RDB\SQL\Builder\Part\Offset\Offset;
use GI\RDB\SQL\Builder\Part\Order\Order;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\SQL\Builder\BuilderInterface;

use GI\RDB\SQL\Builder\Part\Group\GroupInterface;
use GI\RDB\SQL\Builder\Part\Limit\LimitInterface;
use GI\RDB\SQL\Builder\Part\Offset\OffsetInterface;
use GI\RDB\SQL\Builder\Part\Order\OrderInterface;

class PartList implements PartListInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @var PartInterface[]
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
    protected function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @param string $param
     * @return bool
     */
    public function has(string $param)
    {
        return array_key_exists($param, $this->items);
    }

    /**
     * @param string $param
     * @return PartInterface
     * @throws \Exception
     */
    public function get(string $param)
    {
        if (!$this->has($param)) {
            $this->giThrowNotInScopeException($param);
        }

        return $this->items[$param];
    }

    /**
     * @return PartInterface[]
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
     * @param PartInterface $part
     * @return static
     */
    public function add(PartInterface $part)
    {
        $this->items[$part->getPlaceholder()] = $part;

        return $this;
    }

    /**
     * @param array $value
     * @param string $placeholder
     * @return static
     * @throws \Exception
     */
    public function addOrder(array $value, string $placeholder = '')
    {
        $this->add($this->createOrder($value, $placeholder));

        return $this;
    }

    /**
     * @param array $value
     * @param string $placeholder
     * @return OrderInterface
     * @throws \Exception
     */
    protected function createOrder(array $value, string $placeholder)
    {
        try {
            $result = $this->giGetDi(
                OrderInterface::class, null, [$this->getBuilder(), $value, $placeholder]
            );
        } catch (\Exception $e) {
            $result = new Order($this->getBuilder(), $value, $placeholder);
        }

        return $result;
    }

    /**
     * @param array $value
     * @param string $placeholder
     * @return static
     * @throws \Exception
     */
    public function addGroup(array $value, string $placeholder = '')
    {
        $this->add($this->createGroup($value, $placeholder));

        return $this;
    }

    /**
     * @param array $value
     * @param string $placeholder
     * @return GroupInterface
     * @throws \Exception
     */
    protected function createGroup(array $value, string $placeholder)
    {
        try {
            $result = $this->giGetDi(
                GroupInterface::class, null, [$this->getBuilder(), $value, $placeholder]
            );
        } catch (\Exception $e) {
            $result = new Group($this->getBuilder(), $value, $placeholder);
        }

        return $result;
    }

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return static
     */
    public function addLimit($value, string $placeholder = '')
    {
        $this->add($this->createLimit($value, $placeholder));

        return $this;
    }

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return LimitInterface
     */
    protected function createLimit($value, string $placeholder)
    {
        try {
            $result = $this->giGetDi(
                LimitInterface::class, null, [$this->getBuilder(), $value, $placeholder]
            );
        } catch (\Exception $e) {
            $result = new Limit($this->getBuilder(), $value, $placeholder);
        }

        return $result;
    }

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return static
     */
    public function addOffset($value, string $placeholder = '')
    {
        $this->add($this->createOffset($value, $placeholder));

        return $this;
    }

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return OffsetInterface
     */
    protected function createOffset($value, string $placeholder)
    {
        try {
            $result = $this->giGetDi(
                OffsetInterface::class, null, [$this->getBuilder(), $value, $placeholder]
            );
        } catch (\Exception $e) {
            $result = new Offset($this->getBuilder(), $value, $placeholder);
        }

        return $result;
    }

    /**
     * @param string $param
     * @return bool
     */
    public function remove(string $param)
    {
        if ($result = $this->has($param)) {
            unset($this->items[$param]);
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