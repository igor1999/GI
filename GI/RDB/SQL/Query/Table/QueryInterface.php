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
namespace GI\RDB\SQL\Query\Table;

use GI\RDB\SQL\Query\QueryInterface as BaseInterface;

interface QueryInterface extends BaseInterface
{
    /**
     * @param array $searchParams
     * @return static
     */
    public function setSearchParams(array $searchParams = []);

    /**
     * @param string $order
     * @return static
     */
    public function setOrder(string $order = '');

    /**
     * @return static
     */
    public function setOrderToDefault();

    /**
     * @param bool $direction
     * @return static
     */
    public function setDirection(bool $direction);

    /**
     * @param int $limit
     * @return static
     */
    public function setLimit(int $limit = 0);

    /**
     * @param int $offset
     * @return static
     */
    public function setOffset(int $offset = 0);
}