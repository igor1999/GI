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
namespace GI\Filter\Container\Chain;

use GI\Filter\FilterInterface;
use GI\Filter\Container\ContainerInterface;

interface ChainInterface extends ContainerInterface
{
    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return FilterInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @param FilterInterface $filter
     * @return static
     */
    public function add(FilterInterface $filter);

    /**
     * @param int $index
     * @param FilterInterface $filter
     * @return bool
     */
    public function insert(int $index, FilterInterface $filter);

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index);
}