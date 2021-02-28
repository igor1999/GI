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
namespace GI\Calendar\Year;

use GI\Calendar\Base\DateCollectionInterface;

interface CollectionInterface extends DateCollectionInterface
{
    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return YearInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return YearInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return YearInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @return YearInterface[]
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
     * @param YearInterface $day
     * @return bool|int
     */
    public function find(YearInterface $day);
}