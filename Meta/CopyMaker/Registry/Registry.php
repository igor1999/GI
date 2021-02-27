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
namespace GI\Meta\CopyMaker\Registry;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Registry implements RegistryInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var array
     */
    private $items = [];


    /**
     * @param string $hash
     * @return bool
     */
    public function has(string $hash)
    {
        return isset($this->items[$hash]);
    }

    /**
     * @param string $hash
     * @return object
     * @throws \Exception
     */
    public function get(string $hash)
    {
        if (!$this->has($hash)) {
            $this->giThrowNotFoundException('Hash', $hash);
        }

        return $this->items[$hash];
    }

    /**
     * @return array
     */
    protected function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $item
     * @return static
     * @throws \Exception
     */
    public function add($item)
    {
        if (!is_object($item)) {
            $this->giThrowInvalidTypeException('Item', $item, 'object');
        }

        $this->items[spl_object_hash($item)] = $item;

        return $this;
    }

    /**
     * @param string $hash
     * @param mixed $item
     * @return static
     * @throws \Exception
     */
    public function set(string $hash, $item)
    {
        if (!is_object($item)) {
            $this->giThrowInvalidTypeException('Item', $item, 'object');
        }

        $this->items[$hash] = $item;

        return $this;
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
     * @param string $hash
     * @param string $class
     * @return bool
     * @throws \Exception
     */
    public function validateClass(string $hash, string $class)
    {
        return $this->has($hash) && (get_class($this->get($hash)) == $class);
    }
}