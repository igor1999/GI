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
namespace GI\Calendar\Week;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Calendar\Base\Container\ContainerTrait;

class Week implements WeekInterface
{
    use ServiceLocatorAwareTrait, ContainerTrait;


    const NUMBER_OF_DAYS = 7;


    /**
     * Week constructor.
     * @param \DateTime|null $date
     * @throws \Exception
     */
    public function __construct(\DateTime $date = null)
    {
        if (!($date instanceof \DateTime)) {
            $date = new \DateTime();
        }

        $this->firstDate = static::createFirstDate($date);

        $this->lastDate = clone $this->firstDate;
        $interval       = static::NUMBER_OF_DAYS - 1;
        $this->lastDate->add(new \DateInterval('P' . $interval . 'D'));
    }

    /**
     * @param \DateTime|null $date
     * @return \DateTime
     * @throws \Exception
     */
    public static function createFirstDate(\DateTime $date = null)
    {
        $firstDate = clone $date;

        $weekDay = (int)$firstDate->format('N');
        if ($weekDay > 1) {
            $interval = $weekDay - 1;
            $firstDate->sub(new \DateInterval('P' . $interval . 'D'));
        }

        $firstDate->setTime(0, 0, 0);

        return $firstDate;
    }

    /**
     * @param int $interval
     * @return WeekInterface
     * @throws \Exception
     */
    public function getPrevious(int $interval = 1)
    {
        if (!is_numeric($interval) || ($interval <= 0)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Interval', $interval, 'positive integer');
        }

        $interval = $interval * 7;

        $date = clone $this->firstDate;
        $date->sub(new \DateInterval('P' . (int)$interval . 'D'));

        return $this->getGiServiceLocator()->getCalendarFactory()->getWeek($date);
    }

    /**
     * @param int $interval
     * @return WeekInterface
     * @throws \Exception
     */
    public function getNext(int $interval = 1)
    {
        if (!is_numeric($interval) || ($interval <= 0)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Interval', $interval, 'positive integer');
        }

        $interval = $interval * 7;

        $date = clone $this->firstDate;
        $date->add(new \DateInterval('P' . (int)$interval . 'D'));

        return $this->getGiServiceLocator()->getCalendarFactory()->getWeek($date);
    }
}