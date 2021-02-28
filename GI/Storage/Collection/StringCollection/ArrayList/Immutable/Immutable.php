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
namespace GI\Storage\Collection\StringCollection\ArrayList\Immutable;

use GI\Storage\Collection\Behaviour\Service\StringCollection\ArrayList\ArrayList as Service;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Storage\Collection\StringCollection\CollectionTrait;

use GI\Storage\Collection\Behaviour\Service\StringCollection\ArrayList\ArrayListInterface as ServiceInterface;
use GI\Storage\Collection\Behaviour\Option\StringCollection\ArrayList\ArrayListInterface as OptionInterface;

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
        $this->service = $this->giGetDi(ServiceInterface::class, Service::class, [$option]);

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
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return array_key_exists($index, $this->items);
    }

    /**
     * @param int $index
     * @return string
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
     * @return string|mixed
     */
    public function getOptional(int $index, $default = '')
    {
        try {
            $result = $this->get($index);
        } catch (\Exception $exception) {
            $result = $default;
        }

        return $result;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getFirst()
    {
        return $this->get(0);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getLast()
    {
        return $this->get($this->getLength() - 1);
    }

    /**
     * @param string $item
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    protected function add(string $item, int $position = null)
    {
        $this->getService()->validateLength($item);

        if (is_int($position) && $this->has($position)) {
            array_splice($this->items, $position, 0, [$item]);
        } else {
            $this->items[] = $item;
        }

        if (!$this->changeWithoutOrderAndUnique) {
            $this->getService()->order($this->items)->makeUnique($this->items);
        }

        return $this;
    }

    /**
     * @param string[] $items
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    protected function apply(array $items, int $position = null)
    {
        $this->changeWithoutOrderAndUnique = true;

        foreach ($items as $item) {
            $this->add($item, $position);

            if (is_int($position)) {
                $position += 1;
            }
        }

        $this->changeWithoutOrderAndUnique = false;

        $this->getService()->order($this->items)->makeUnique($this->items);

        return $this;
    }

    /**
     * @param string[] $items
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
     * @param string $source
     * @param string $itemGlue
     * @return static
     * @throws \Exception
     */
    protected function read(string $source, string $itemGlue)
    {
        $items = $this->giGetSplitter()->split($source, $itemGlue);

        $this->setItems($items);

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
     * @param string $needle
     * @return bool
     */
    protected function removeItem(string $needle)
    {
        $found = $this->find($needle);

        foreach (array_reverse($found) as $index) {
            $this->remove($index);
        }

        return !empty($found);
    }
}