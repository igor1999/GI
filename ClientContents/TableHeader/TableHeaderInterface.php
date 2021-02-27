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
namespace GI\ClientContents\TableHeader;

use GI\ClientContents\TableHeader\Column\ColumnInterface;

interface TableHeaderInterface 
{
    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return ColumnInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return ColumnInterface[]
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
     * @param string $orderAttribute
     * @return static
     */
    public function setOrder(string $orderAttribute);

    /**
     * @param bool $direction
     * @return static
     */
    public function setDirection(bool $direction);

    /**
     * @param string $orderAttribute
     * @param bool $direction
     * @return static
     */
    public function setOrderAndDirection(string $orderAttribute, bool $direction);
}