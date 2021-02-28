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
namespace GI\RDB\Meta\Column;

use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\RDB\Meta\Table\TableInterface;

interface ColumnListInterface extends ExtractionInterface
{
    /**
     * @return TableInterface
     */
    public function getTable();

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name);

    /**
     * @param string $name
     * @return ColumnInterface
     */
    public function get(string $name);

    /**
     * @return ColumnInterface[]
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
     * @param string $name
     * @return bool
     */
    public function hasPrimaryAttribute(string $name);

    /**
     * @param string $name
     * @return ColumnInterface
     */
    public function getPrimaryAttribute(string $name);

    /**
     * @return bool
     */
    public function hasPrimary();

    /**
     * @return ColumnInterface[]
     */
    public function getPrimary();

    /**
     * @return ColumnInterface[]
     */
    public function getNonPrimary();

    /**
     * @return bool
     */
    public function hasIdentity();

    /**
     * @return ColumnInterface
     * @throws \Exception
     */
    public function getIdentity();

    /**
     * @return ColumnInterface[]
     */
    public function getNonIdentity();
}