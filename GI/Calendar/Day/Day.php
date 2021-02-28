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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Calendar\Week\WeekInterface;
use GI\Calendar\Year\YearInterface;
use GI\Calendar\Month\MonthInterface;

class Day implements DayInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var \DateTime
     */
    private $date;


    /**
     * Day constructor.
     * @param \DateTime|null $date
     */
    public function __construct(\DateTime $date = null)
    {
        if (!($date instanceof \DateTime)) {
            $date = new \DateTime();
        }

        $this->date = clone $date;
        $this->date->setTime(0, 0, 0);
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return clone $this->date;
    }

    /**
     * @return int
     */
    public function getNumberInMonth()
    {
        return (int)$this->date->format('j');
    }

    /**
     * @return int
     */
    public function getNumberInWeek()
    {
        return (int)$this->date->format('N');
    }

    /**
     * @return int
     */
    public function getNumberInYear()
    {
        return (int)$this->date->format('z') + 1;
    }

    /**
     * @return string
     */
    public function getShortNameInWeek()
    {
        return $this->date->format('D');
    }

    /**
     * @return string
     */
    public function getFullNameInWeek()
    {
        return $this->date->format('l');
    }

    /**
     * @param int $interval
     * @return DayInterface
     * @throws \Exception
     */
    public function getPrevious(int $interval = 1)
    {
        if (!is_numeric($interval) || ($interval <= 0)) {
            $this->giThrowInvalidTypeException('Interval', $interval, 'positive integer');
        }

        $date = clone $this->date;
        $date->sub(new \DateInterval('P' . (int)$interval . 'D'));

        return $this->giGetCalendarFactory()->getDay($date);
    }

    /**
     * @param int $interval
     * @return DayInterface
     * @throws \Exception
     */
    public function getNext(int $interval = 1)
    {
        if (!is_numeric($interval) || ($interval <= 0)) {
            $this->giThrowInvalidTypeException('Interval', $interval, 'positive integer');
        }

        $date = clone $this->date;
        $date->add(new \DateInterval('P' . (int)$interval . 'D'));

        return $this->giGetCalendarFactory()->getDay($date);
    }

    /**
     * @return WeekInterface
     */
    public function getWeek()
    {
        return $this->giGetCalendarFactory()->getWeek($this->getDate());
    }

    /**
     * @return MonthInterface
     */
    public function getMonth()
    {
        return $this->giGetCalendarFactory()->getMonth($this->getDate());
    }

    /**
     * @return YearInterface
     */
    public function getYear()
    {
        return $this->giGetCalendarFactory()->getYear($this->getDate());
    }

    /**
     * @param DayInterface $day
     * @return int
     */
    public function compare(DayInterface $day)
    {
        $myTimestamp    = $this->date->getTimestamp();
        $otherTimestamp = $day->getDate()->getTimestamp();

        if ($myTimestamp < $otherTimestamp) {
            $result = -1;
        } elseif ($myTimestamp > $otherTimestamp) {
            $result = 1;
        } else {
            $result = 0;
        }

        return $result;
    }

    /**
     * @param DayInterface $day
     * @return bool
     */
    public function Equal(DayInterface $day)
    {
        return $this->compare($day) == 0;
    }

    /**
     * @param DayInterface $day
     * @return bool
     */
    public function isPastFor(DayInterface $day)
    {
        return $this->compare($day) == -1;
    }

    /**
     * @param DayInterface $day
     * @return bool
     */
    public function isFutureFor(DayInterface $day)
    {
        return $this->compare($day) == 1;
    }
}