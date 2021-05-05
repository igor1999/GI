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
namespace GI\ClientContents\TableOrdering;

interface TableOrderingInterface
{
    /**
     * @return string
     */
    public function getCriteria();

    /**
     * @return bool
     */
    public function isBothDirections();

    /**
     * @return bool|null
     */
    public function getOrdering();

    /**
     * @param string $orderCriteria
     * @param bool $orderDirection
     * @return static
     */
    public function setOrdering(string $orderCriteria, bool $orderDirection);

    /**
     * @return bool
     */
    public function isAscendant();

    /**
     * @return bool
     */
    public function isDescendant();

    /**
     * @return bool
     */
    public function isNone();

    /**
     * @return bool
     */
    public function getNextDirection();

    /**
     * @return string
     */
    public function getNextDirectionAsString();
}