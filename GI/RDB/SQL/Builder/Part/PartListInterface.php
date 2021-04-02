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
namespace GI\RDB\SQL\Builder\Part;

interface PartListInterface
{
    /**
     * @param string $param
     * @return bool
     */
    public function has(string $param);

    /**
     * @param string $param
     * @return PartInterface
     * @throws \Exception
     */
    public function get(string $param);

    /**
     * @return PartInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return int
     */
    public function isEmpty();

    /**
     * @param PartInterface $part
     * @return static
     */
    public function add(PartInterface $part);

    /**
     * @param array $value
     * @param string $placeholder
     * @return static
     * @throws \Exception
     */
    public function addOrder(array $value, string $placeholder = '');

    /**
     * @param array $value
     * @param string $placeholder
     * @return static
     * @throws \Exception
     */
    public function addGroup(array $value, string $placeholder = '');

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return static
     */
    public function addLimit($value, string $placeholder = '');

    /**
     * @param mixed $value
     * @param string $placeholder
     * @return static
     */
    public function addOffset($value, string $placeholder = '');

    /**
     * @param string $param
     * @return bool
     */
    public function remove(string $param);

    /**
     * @return static
     */
    public function clean();

    /**
     * @return static
     */
    public function build();
}