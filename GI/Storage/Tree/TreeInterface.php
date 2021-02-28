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
namespace GI\Storage\Tree;

use GI\Pattern\ArrayExchange\ArrayExchangeInterface;
use GI\Pattern\Closing\ClosingInterface;
use GI\SessionExchange\BaseInterface\CacheClassInterface;

interface TreeInterface extends ArrayExchangeInterface, ClosingInterface, CacheClassInterface
{
    /**
     * @param array $keys
     * @return TreeInterface
     * @throws \Exception
     */
    public function findNodeRecursive(array $keys);

    /**
     * @param string|int $key
     * @return bool
     */
    public function hasLocally($key);

    /**
     * @param string|int|array $key
     * @return bool
     * @throws \Exception
     */
    public function has($key);

    /**
     * @param string|int $key
     * @return mixed
     * @throws \Exception
     */
    public function getLocally($key);

    /**
     * @param string|int|array $key
     * @return mixed
     * @throws \Exception
     */
    public function get($key);

    /**
     * @param string|int|array $key
     * @param mixed|null $defaultValue
     * @return mixed
     */
    public function getOptional($key, $defaultValue = null);

    /**
     * @return array
     */
    public function getNodes();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param mixed $element
     * @return array|false
     */
    public function findKey($element);

    /**
     * @param mixed $element
     * @return bool
     */
    public function contains($element);

    /**
     * @return array
     * @throws \Exception
     */
    public function extract();

    /**
     * @param string|int|array $key
     * @param mixed $newNode
     * @return static
     * @throws \Exception
     */
    public function set($key, $newNode);

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function apply(array $contents);

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $contents);

    /**
     * @param string|int|array $key
     * @return bool
     * @throws \Exception
     */
    public function remove($key);

    /**
     * @return static
     * @throws \Exception
     */
    public function clean();
}