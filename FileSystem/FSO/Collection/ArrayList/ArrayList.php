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
namespace GI\FileSystem\FSO\Collection\ArrayList;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\FileSystem\FSO\Collection\CollectionTrait as FSOCollectionTrait;

use GI\FileSystem\FSO\FSOInterface;

class ArrayList implements ArrayListInterface
{
    use ServiceLocatorAwareTrait, FSOCollectionTrait;


    /**
     * ArrayList constructor.
     * @param FSOInterface[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return isset($this->items[$index]);
    }

    /**
     * @param int $index
     * @return FSOInterface
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
     * @param FSOInterface $fso
     * @return static
     */
    public function add(FSOInterface $fso)
    {
        $this->items[] = $fso;

        return $this;
    }

    /**
     * @param int $index
     * @param FSOInterface $fso
     * @return static
     */
    public function insert(int $index, FSOInterface $fso)
    {
        if (!$this->has($index)) {
            $this->add($fso);
        } else {
            array_splice($this->items, $index, 0, [$fso]);
        }

        return $this;
    }

    /**
     * @param int $index
     * @param FSOInterface $fso
     * @return static
     * @throws \Exception
     */
    public function set(int $index, FSOInterface $fso)
    {
        $this->get($index);
        $this->items[$index] = $fso;

        return $this;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index)
    {
        if ($result = $this->has($index)) {
            array_splice($this->items, $index, 1);
        }

        return $result;
    }
}