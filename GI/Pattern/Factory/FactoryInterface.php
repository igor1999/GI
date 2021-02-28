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
namespace GI\Pattern\Factory;

use GI\Pattern\Factory\ClassContainer\ContainerInterface;

interface FactoryInterface 
{
    /**
     * @return bool|\Closure
     */
    public function isCached();

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return ContainerInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return ContainerInterface[]
     */
    public function getItems();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param string $method
     * @param array $arguments
     * @param string $prefix
     * @return mixed
     * @throws \Exception
     */
    public function create(string $method, array $arguments = [], string $prefix = '');

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixGet(string $method, array $arguments = []);

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixSet(string $method, array $arguments = []);

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixAdd(string $method, array $arguments = []);

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixInsert(string $method, array $arguments = []);

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixCreate(string $method, array $arguments = []);
}