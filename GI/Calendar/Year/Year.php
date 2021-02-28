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

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Calendar\Base\Container\ContainerTrait;

use GI\Calendar\Week\CollectionInterface as WeekCollectionInterface;
use GI\Calendar\Month\CollectionInterface as MonthCollectionInterface;

class Year implements YearInterface
{
    use ServiceLocatorAwareTrait, ContainerTrait;


    /**
     * Year constructor.
     * @param \DateTime|null $date
     */
    public function __construct(\DateTime $date = null)
    {
        if (!($date instanceof \DateTime)) {
            $date = new \DateTime();
        }

        $this->firstDate = clone $date;
        $this->firstDate->setDate($date->format('Y'), 1, 1);
        $this->firstDate->setTime(0, 0, 0);

        $this->lastDate = clone $this->firstDate;
        $this->lastDate->setDate($date->format('Y'), 12, 31);
    }

    /**
     * @return int
     */
    public function isLeap()
    {
        return (int)$this->firstDate->format('L');
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return (int)$this->firstDate->format('Y');
    }

    /**
     * @param int $interval
     * @return YearInterface
     * @throws \Exception
     */
    public function getPrevious(int $interval = 1)
    {
        if (!is_numeric($interval) || ($interval <= 0)) {
            $this->giThrowInvalidTypeException('Interval', $interval, 'positive integer');
        }

        $date = clone $this->firstDate;
        $date->sub(new \DateInterval('P' . (int)$interval . 'Y'));

        return $this->giGetCalendarFactory()->getYear($date);
    }

    /**
     * @param int $interval
     * @return YearInterface
     * @throws \Exception
     */
    public function getNext(int $interval = 1)
    {
        if (!is_numeric($interval) || ($interval <= 0)) {
            $this->giThrowInvalidTypeException('Interval', $interval, 'positive integer');
        }

        $date = clone $this->firstDate;
        $date->add(new \DateInterval('P' . (int)$interval . 'Y'));

        return $this->giGetCalendarFactory()->getYear($date);
    }

    /**
     * @return WeekCollectionInterface
     */
    public function getWeeks()
    {
        return $this->giGetCalendarFactory()->getWeekCollection($this->firstDate, $this->lastDate);
    }

    /**
     * @return MonthCollectionInterface
     */
    public function getMonths()
    {
        return $this->giGetCalendarFactory()->getMonthCollection($this->firstDate, $this->lastDate);
    }
}