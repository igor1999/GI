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
namespace GI\REST\Route\Chain;

use GI\REST\Route\RouteInterface;
use GI\REST\Request\Server\ServerInterface;

interface ChainInterface extends RouteInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return RouteInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return RouteInterface[]
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
     * @return bool
     * @throws \Exception
     */
    public function remove(string $key);

    /**
     * @return static
     * @throws \Exception
     */
    public function clean();

    /**
     * @param array $keys
     * @return ChainInterface
     * @throws \Exception
     */
    public function findChainRecursive(array $keys);

    /**
     * @param string $param
     * @return bool
     */
    public function hasParam(string $param);

    /**
     * @param string $source
     * @return bool
     * @throws \Exception
     */
    public function validateByString(string $source);

    /**
     * @param ServerInterface $server
     * @return bool
     * @throws \Exception
     */
    public function validateByServer(ServerInterface $server);
}