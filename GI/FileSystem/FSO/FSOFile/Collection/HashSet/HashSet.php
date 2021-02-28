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
namespace GI\FileSystem\FSO\FSOFile\Collection\HashSet;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\FileSystem\FSO\FSOFile\Collection\CollectionTrait as FSOFileCollectionTrait;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

class HashSet implements HashSetInterface
{
    use ServiceLocatorAwareTrait, FSOFileCollectionTrait;


    /**
     * HashSet constructor.
     * @param FSOFileInterface[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->set($key, $item);
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
     * @return FSOFileInterface
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
     * @return FSOFileInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        reset($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return FSOFileInterface
     * @throws \Exception
     */
    public function getLast()
    {
        end($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @param string $key
     * @param FSOFileInterface $file
     * @return static
     */
    public function set(string $key, FSOFileInterface $file)
    {
        $this->items[$key] = $file;

        return $this;
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
}