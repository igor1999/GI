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
namespace GI\Storage\Collection\FloatCollection\HashSet\Immutable;

use GI\Storage\Collection\Behaviour\Service\FloatCollection\HashSet\HashSet as Service;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Storage\Collection\FloatCollection\CollectionTrait;

use GI\Storage\Collection\Behaviour\Service\FloatCollection\HashSet\HashSetInterface as ServiceInterface;
use GI\Storage\Collection\Behaviour\Option\FloatCollection\HashSet\HashSetInterface as OptionInterface;

class Immutable implements ImmutableInterface
{
    use ServiceLocatorAwareTrait, CollectionTrait;


    /**
     * @var ServiceInterface
     */
    private $service;


    /**
     * Immutable constructor.
     * @param string[] $items
     * @param OptionInterface|null $option
     * @throws \Exception
     */
    public function __construct(array $items = [], OptionInterface $option = null)
    {
        $this->service = $this->getGiServiceLocator()->getDependency(ServiceInterface::class, Service::class, [$option]);

        $this->setItems($items);
    }

    /**
     * @return ServiceInterface
     */
    public function getService()
    {
        return $this->service;
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
     * @return float
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
     * @param string $key
     * @param float|mixed $default
     * @return float|mixed
     */
    public function getOptional(string $key, $default = '')
    {
        try {
            $result = $this->get($key);
        } catch (\Exception $exception) {
            $result = $default;
        }

        return $result;
    }

    /**
     * @param int $position
     * @return bool
     */
    public function hasPosition(int $position)
    {
        return ($position >= 0) && ($position <= ($this->getLength() - 1));
    }

    /**
     * @param int $position
     * @return string
     * @throws \Exception
     */
    public function getKeyByPosition(int $position)
    {
        if (!$this->hasPosition($position)) {
            $this->getGiServiceLocator()->throwNotInScopeException($position);
        }

        $content = array_slice($this->items, $position, 1, true);
        $keys    = array_keys($content);

        return array_shift($keys);
    }

    /**
     * @param int $position
     * @return float
     * @throws \Exception
     */
    public function getByPosition(int $position)
    {
        if (!$this->hasPosition($position)) {
            $this->getGiServiceLocator()->throwNotInScopeException($position);
        }

        $content = array_slice($this->items, $position, 1, true);

        return array_shift($content);
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getLast()
    {
        return $this->getByPosition($this->getLength() - 1);
    }

    /**
     * @param string $key
     * @return int
     * @throws \Exception
     */
    public function findPositionOfKey(string $key)
    {
        if (!$this->has($key)) {
            $this->getGiServiceLocator()->throwNotInScopeException($key);
        }

        $keys = array_keys($this->items);

        return array_search($key, $keys);
    }

    /**
     * @param float $item
     * @return int
     * @throws \Exception
     */
    public function findPositionOfItem(float $item)
    {
        $key = $this->findOne($item);

        return $this->findPositionOfKey($key);
    }

    /**
     * @param string $key
     * @param int $distance
     * @return string
     * @throws \Exception
     */
    public function getNextKey(string $key, int $distance = 1)
    {
        $position = $this->findPositionOfKey($key) + $distance;

        return $this->getKeyByPosition($position);
    }

    /**
     * @param string $key
     * @param int $distance
     * @return float
     * @throws \Exception
     */
    public function getNextItem(string $key, int $distance = 1)
    {
        return $this->get($this->getNextKey($key, $distance));
    }

    /**
     * @param string $key
     * @param float $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    protected function set(string $key, float $item, int $position = null)
    {
        $this->getService()->validateBounds($item);

        if (!is_int($position) || !$this->hasPosition($position) || $this->has($key)) {
            $this->items[$key] = $item;
        } else {
            $head = array_slice($this->items,0, $position, true);
            $tail = array_slice($this->items, $position, null, true);
            $this->items = array_merge($head, [$key => $item], $tail);
        }

        if (!$this->changeWithoutOrderAndUnique) {
            $this->getService()->order($this->items)->makeUnique($this->items);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $anchor
     * @param float $item
     * @return static
     * @throws \Exception
     */
    protected function insertBefore(string $key, string $anchor, float $item)
    {
        return $this->set($key, $item, $this->findPositionOfKey($anchor));
    }

    /**
     * @param float[] $items
     * @return static
     * @throws \Exception
     */
    protected function apply(array $items)
    {
        $this->changeWithoutOrderAndUnique = true;

        foreach ($items as $key => $item) {
            $this->set($key, $item);
        }

        $this->changeWithoutOrderAndUnique = false;

        $this->getService()->order($this->items)->makeUnique($this->items);

        return $this;
    }

    /**
     * @param float[] $items
     * @return static
     * @throws \Exception
     */
    protected function setItems(array $items)
    {
        $this->clean()->apply($items);

        return $this;
    }

    /**
     * @param ImmutableInterface $collection
     * @return static
     * @throws \Exception
     */
    protected function merge(ImmutableInterface $collection)
    {
        $this->apply($collection->getItems());

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
     * @param float $needle
     * @return bool
     */
    protected function removeItem(float $needle)
    {
        $found = $this->find($needle);

        foreach ($found as $key) {
            $this->remove($key);
        }

        return !empty($found);
    }

    /**
     * @param int $position
     * @return bool
     * @throws \Exception
     */
    protected function removeByPosition(int $position)
    {
        if ($result = $this->hasPosition($position)) {
            $key = $this->getKeyByPosition($position);
            $this->remove($key);
        }

        return $result;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function pop()
    {
        return $this->removeByPosition($this->getLength() - 1);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return bool|float
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        $result = null;

        try {
            $has = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixHas($method);
        } catch (\Exception $exception) {
            try {
                $get = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixGet($method);
            } catch (\Exception $exception) {
                try {
                    list($is, $value) = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseBoolGetterWithValue($method);
                } catch (\Exception $exception) {
                    try {
                        $is = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixIs($method);
                    } catch (\Exception $exception) {
                        $this->getGiServiceLocator()->throwMagicMethodException($method);
                    }
                }
            }
        }

        if (!empty($has)) {
            $has = $this->getService()->formatKey($has);
            $result = $this->has($has);
        } elseif (!empty($get)) {
            $get = $this->getService()->formatKey($get);
            $result = $this->get($get);
        } elseif (!empty($is) && !empty($value)) {
            $is = $this->getService()->formatKey($is);
            $result = $this->has($is) && ($this->get($is) == $value);
        } elseif (!empty($is)) {
            $is = $this->getService()->formatKey($is);
            $result = $this->has($is) && (bool)$this->get($is);
        }

        return $result;
    }
}