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
namespace GI\FileSystem\FSO\FSODir\Collection\ArrayList;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\FileSystem\FSO\FSODir\Collection\CollectionTrait as FSODirCollectionTrait;

use GI\FileSystem\FSO\FSODir\FSODirInterface;

class ArrayList implements ArrayListInterface
{
    use ServiceLocatorAwareTrait, FSODirCollectionTrait;


    /**
     * ArrayList constructor.
     * @param FSODirInterface[] $items
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
     * @return FSODirInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->getGiServiceLocator()->throwNotInScopeException($index);
        }

        return $this->items[$index];
    }

    /**
     * @param FSODirInterface $dir
     * @return static
     */
    public function add(FSODirInterface $dir)
    {
        $this->items[] = $dir;

        return $this;
    }

    /**
     * @param int $index
     * @param FSODirInterface $dir
     * @return static
     */
    public function insert(int $index, FSODirInterface $dir)
    {
        if (!$this->has($index)) {
            $this->add($dir);
        } else {
            array_splice($this->items, $index, 0, [$dir]);
        }

        return $this;
    }

    /**
     * @param int $index
     * @param FSODirInterface $fso
     * @return static
     * @throws \Exception
     */
    public function set(int $index, FSODirInterface $fso)
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