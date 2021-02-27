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
namespace GI\Calendar\Month;

use GI\Calendar\Base\Container\ContainerInterface;
use GI\Calendar\Base\DateUnitInterface;
use GI\Calendar\Week\CollectionInterface as WeekCollectionInterface;
use GI\Calendar\Year\YearInterface;

interface MonthInterface extends ContainerInterface, DateUnitInterface
{
    /**
     * @return int
     */
    public function getNumber();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return string
     */
    public function getShortName();

    /**
     * @return string
     */
    public function getFullName();

    /**
     * @param int $interval
     * @return static
     * @throws \Exception
     */
    public function getPrevious(int $interval = 1);

    /**
     * @param int $interval
     * @return static
     * @throws \Exception
     */
    public function getNext(int $interval = 1);

    /**
     * @return WeekCollectionInterface
     */
    public function getWeeks();

    /**
     * @return YearInterface
     */
    public function getYear();
}