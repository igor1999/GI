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
namespace GI\RDB\Meta\Table;

use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\RDB\Driver\DriverInterface;

interface TableListInterface extends ExtractionInterface
{
    /**
     * @return DriverInterface
     */
    public function getDriver();

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name);

    /**
     * @param string $name
     * @return TableInterface
     * @throws \Exception
     */
    public function get(string $name);

    /**
     * @return TableInterface[]
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
     * @param string $namePart
     * @return TableInterface[]
     * @throws \Exception
     */
    public function find(string $namePart);
}