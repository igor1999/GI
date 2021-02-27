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
namespace GI\FileSystem\FSO\FSOFile\Collection\ArrayList;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\FileSystem\FSO\FSOFile\Collection\CollectionTrait as FSOFileCollectionTrait;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

class ArrayList implements ArrayListInterface
{
    use ServiceLocatorAwareTrait, FSOFileCollectionTrait;


    /**
     * ArrayList constructor.
     * @param FSOFileInterface[] $items
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
     * @return FSOFileInterface
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
     * @param FSOFileInterface $file
     * @return static
     */
    public function add(FSOFileInterface $file)
    {
        $this->items[] = $file;

        return $this;
    }

    /**
     * @param int $index
     * @param FSOFileInterface $file
     * @return static
     */
    public function insert(int $index, FSOFileInterface $file)
    {
        if (!$this->has($index)) {
            $this->add($file);
        } else {
            array_splice($this->items, $index, 0, [$file]);
        }

        return $this;
    }

    /**
     * @param int $index
     * @param FSOFileInterface $fso
     * @return static
     * @throws \Exception
     */
    public function set(int $index, FSOFileInterface $fso)
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