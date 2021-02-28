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
namespace GI\Markup\Reader\Base;

use GI\Markup\Reader\Base\Node\NodeInterface;

interface CollectionInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return NodeInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return NodeInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param string $key
     * @param NodeInterface $item
     * @return static
     */
    public function set(string $key, NodeInterface $item);

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key);

    /**
     * @return static
     */
    public function clean();

    /**
     * @param array $keys
     * @return NodeInterface
     * @throws \Exception
     */
    public function findNodeRecursive(array $keys);
}