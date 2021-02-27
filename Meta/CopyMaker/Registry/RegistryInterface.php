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

interface RegistryInterface
{
    /**
     * @param string $hash
     * @return bool
     */
    public function has(string $hash);

    /**
     * @param string $hash
     * @return object
     * @throws \Exception
     */
    public function get(string $hash);

    /**
     * @param mixed $item
     * @return static
     * @throws \Exception
     */
    public function add($item);

    /**
     * @param string $hash
     * @param mixed $item
     * @return static
     * @throws \Exception
     */
    public function set(string $hash, $item);

    /**
     * @return static
     */
    public function clean();

    /**
     * @param string $hash
     * @param string $class
     * @return bool
     * @throws \Exception
     */
    public function validateClass(string $hash, string $class);
}