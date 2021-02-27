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
namespace GI\Storage\Collection\IntCollection;

use GI\Storage\Collection\CollectionInterface as BaseInterface;

interface CollectionInterface extends BaseInterface
{
    /**
     * @return int[]
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
     * @param int $needle
     * @return array
     */
    public function find(int $needle);

    /**
     * @param int $needle
     * @return mixed
     * @throws \Exception
     */
    public function findOne(int $needle);

    /**
     * @param int $needle
     * @return bool
     */
    public function contains(int $needle);

    /**
     * @param \Closure $filter
     * @return int[]
     */
    public function findByClosure(\Closure $filter);

    /**
     * @param \Closure $filter
     * @return int
     * @throws \Exception
     */
    public function findOneByClosure(\Closure $filter);

    /**
     * @param \Closure $filter
     * @return bool
     */
    public function containsByClosure(\Closure $filter);

    /**
     * @return int
     */
    public function sum();

    /**
     * @return int
     */
    public function product();

    /**
     * @param string $separator
     * @return string
     */
    public function join(string $separator);

    /**
     * @return bool[]
     */
    public function getItemsAsBool();

    /**
     * @return float[]
     */
    public function getItemsAsFloat();

    /**
     * @return string[]
     */
    public function getItemsAsString();
}