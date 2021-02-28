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
namespace GI\Meta\Constant;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Meta\ClassMeta\Behaviour\OwnerAware\OwnerTrait;

use GI\Meta\ClassMeta\ClassMetaInterface;

class ConstantList implements ConstantListInterface
{
    use ServiceLocatorAwareTrait, OwnerTrait;


    /**
     * @var array
     */
    private $items = [];


    /**
     * ConstantList constructor.
     * @param ClassMetaInterface $owner
     * @throws \Exception
     */
    public function __construct(ClassMetaInterface $owner)
    {
        $this->owner = $owner;

        $this->setItems($this->owner->getReflection()->getConstants());
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
     * @return mixed
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getOptional(string $key, $default = null)
    {
        try {
            $result = $this->get($key);
        } catch (\Exception $exception) {
            $result = $default;
        }

        return $result;
    }

    /**
     * @return array
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
     * @param string $key
     * @param mixed $item
     * @return static
     * @throws \Exception
     */
    protected function set(string $key, $item)
    {
        $this->items[$key] = $item;

        return $this;
    }

    /**
     * @param array $items
     * @return static
     * @throws \Exception
     */
    protected function setItems(array $items)
    {
        foreach ($items as $key => $item) {
            $this->set($key, $item);
        }

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function remove(string $key)
    {
        if ($result = $this->has($key)) {
            unset($this->items[$key]);
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
}