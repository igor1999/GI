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
namespace GI\Calendar\Day;

use GI\Calendar\Base\DateUnitInterface;
use GI\Calendar\Month\MonthInterface;
use GI\Calendar\Week\WeekInterface;
use GI\Calendar\Year\YearInterface;

interface DayInterface extends DateUnitInterface
{
    /**
     * @return \DateTime
     */
    public function getDate();

    /**
     * @return int
     */
    public function getNumberInMonth();

    /**
     * @return int
     */
    public function getNumberInWeek();

    /**
     * @return int
     */
    public function getNumberInYear();

    /**
     * @return string
     */
    public function getShortNameInWeek();

    /**
     * @return string
     */
    public function getFullNameInWeek();

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
     * @return WeekInterface
     */
    public function getWeek();

    /**
     * @return MonthInterface
     */
    public function getMonth();

    /**
     * @return YearInterface
     */
    public function getYear();

    /**
     * @param DayInterface $day
     * @return int
     */
    public function compare(DayInterface $day);

    /**
     * @param DayInterface $day
     * @return bool
     */
    public function Equal(DayInterface $day);

    /**
     * @param DayInterface $day
     * @return bool
     */
    public function isPastFor(DayInterface $day);

    /**
     * @param DayInterface $day
     * @return bool
     */
    public function isFutureFor(DayInterface $day);
}