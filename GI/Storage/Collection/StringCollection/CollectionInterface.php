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
namespace GI\Storage\Collection\StringCollection;

use GI\Storage\Collection\CollectionInterface as BaseInterface;

interface CollectionInterface extends BaseInterface
{
    /**
     * @return string[]
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
     * @param string $needle
     * @return array
     */
    public function find(string $needle);

    /**
     * @param string $needle
     * @return mixed
     * @throws \Exception
     */
    public function findOne(string $needle);

    /**
     * @param string $needle
     * @return bool
     */
    public function contains(string $needle);

    /**
     * @param \Closure $filter
     * @return string[]
     */
    public function findByClosure(\Closure $filter);

    /**
     * @param \Closure $filter
     * @return string
     * @throws \Exception
     */
    public function findOneByClosure(\Closure $filter);

    /**
     * @param \Closure $filter
     * @return bool
     */
    public function containsByClosure(\Closure $filter);

    /**
     * @param string $itemGlue
     * @return string
     */
    public function join(string $itemGlue);

    /**
     * @return bool[]
     */
    public function getItemsAsBool();

    /**
     * @return float[]
     */
    public function getItemsAsFloat();

    /**
     * @return int[]
     */
    public function getItemsAsInt();
}