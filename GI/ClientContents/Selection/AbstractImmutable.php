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
namespace GI\ClientContents\Selection;

use GI\ClientContents\Selection\Item\Item;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\Selection\Item\ItemInterface;

abstract class AbstractImmutable implements ImmutableInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ItemInterface[]
     */
    private $items = [];


    /**
     * @param string $value
     * @return bool
     */
    public function has(string $value)
    {
        return isset($this->items[$value]);
    }

    /**
     * @param string $value
     * @return ItemInterface
     * @throws \Exception
     */
    public function get(string $value)
    {
        if (!$this->has($value)) {
            $this->giThrowNotInScopeException($value);
        }

        return $this->items[$value];
    }

    /**
     * @return ItemInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return string[]
     */
    public function getValues()
    {
        return array_keys($this->getItems());
    }

    /**
     * @return string[]
     */
    public function getTexts()
    {
        return array_values($this->getItems());
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
     * @param bool $selected
     * @return ItemInterface[]
     */
    public function getSelectedItems(bool $selected = true)
    {
        $f = function(ItemInterface $item) use ($selected)
        {
            return $item->isSelected() === (bool)$selected;
        };

        return array_filter($this->getItems(), $f);
    }

    /**
     * @param string $value
     * @param string $text
     * @param bool $selected
     * @return static
     */
    protected function set(string $value, string $text, bool $selected = false)
    {
        $this->items[$value] = $this->createItem($value, $text, $selected);

        return $this;
    }

    /**
     * @param string $anchor
     * @param string $value
     * @param string $text
     * @param bool $selected
     * @return static
     * @throws \Exception
     */
    protected function insertBefore(string $anchor, string $value, string $text, bool $selected = false)
    {
        $this->items = $this->giGetStorageFactory()
            ->createMixedHashSetAlterable($this->items)
            ->insertBefore($anchor, $value, $this->createItem($value, $text, $selected))
            ->getItems();

        return $this;
    }

    /**
     * @param array $source
     * @return static
     */
    protected function setMany(array $source)
    {
        $this->clean();

        foreach ($source as $value => $text) {
            $this->set($value, $text);
        }

        return $this;
    }

    /**
     * @param string $value
     * @param string $text
     * @param bool $selected
     * @return ItemInterface
     */
    protected function createItem(string $value, string $text, bool $selected)
    {
        try {
            $result = $this->giGetDi(
                ItemInterface::class, Item::class, [$this, $value, $text, $selected]
            );
        } catch (\Exception $e) {
            $result = new Item($this, $value, $text, $selected);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function cleanSelections()
    {
        foreach ($this->items as $item) {
            $item->setSelected(false);
        }

        return $this;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function remove(string $value)
    {
        if ($result = $this->has($value)) {
            unset($this->items[$value]);
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