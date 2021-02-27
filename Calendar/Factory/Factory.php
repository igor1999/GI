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
namespace GI\Calendar\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\Calendar\Day\Day;
use GI\Calendar\Day\Collection as DayCollection;
use GI\Calendar\Week\Week;
use GI\Calendar\Week\Collection as WeekCollection;
use GI\Calendar\Month\Month;
use GI\Calendar\Month\Collection as MonthCollection;
use GI\Calendar\Year\Year;
use GI\Calendar\Year\Collection as YearCollection;


use GI\Calendar\Day\DayInterface;
use GI\Calendar\Day\CollectionInterface as DayCollectionInterface;
use GI\Calendar\Week\WeekInterface;
use GI\Calendar\Week\CollectionInterface as WeekCollectionInterface;
use GI\Calendar\Month\MonthInterface;
use GI\Calendar\Month\CollectionInterface as MonthCollectionInterface;
use GI\Calendar\Year\YearInterface;
use GI\Calendar\Year\CollectionInterface as YearCollectionInterface;

use GI\Calendar\Base\DateUnitInterface;
use GI\Calendar\Base\DateCollectionInterface;

/**
 * Class Factory
 * @package GI\Calendar\Factory
 *
 * @method DayInterface getDay(\DateTime $date = null)
 * @method DayCollectionInterface getDayCollection(\DateTime $firstDate, \DateTime $lastDate)
 * @method WeekInterface getWeek(\DateTime $date = null)
 * @method WeekCollectionInterface getWeekCollection(\DateTime $firstDate, \DateTime $lastDate)
 * @method MonthInterface getMonth(\DateTime $date = null)
 * @method MonthCollectionInterface getMonthCollection(\DateTime $firstDate, \DateTime $lastDate)
 * @method YearInterface getYear(\DateTime $date = null)
 * @method YearCollectionInterface getYearCollection(\DateTime $firstDate, \DateTime $lastDate)
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $dayFunc = function(\DateTime $date = null)
        {
            return $this->getKey('Y-m-d', $date);
        };

        $weekFunc = function(\DateTime $date = null)
        {
            return $this->getWeekKey($date);
        };

        $monthFunc = function(\DateTime $date = null)
        {
            return $this->getKey('Y-m', $date);
        };

        $yearFunc = function(\DateTime $date = null)
        {
            return $this->getKey('Y', $date);
        };

        $this->getTemplateClasses()->add(DateUnitInterface::class)->add(DateCollectionInterface::class);

        $this->setPrefixToGet()
            ->set(Day::class, $dayFunc)
            ->setNamed('DayCollection',DayCollection::class)
            ->set(Week::class, $weekFunc)
            ->setNamed('WeekCollection',WeekCollection::class)
            ->set(Month::class, $monthFunc)
            ->setNamed('MonthCollection',MonthCollection::class)
            ->set(Year::class, $yearFunc)
            ->setNamed('YearCollection',YearCollection::class);
    }

    /**
     * @param string $format
     * @param \DateTime|null $date
     * @return string
     * @throws \Exception
     */
    protected function getKey(string $format, \DateTime $date = null)
    {
        if (!($date instanceof \DateTime)) {
            $date = new \DateTime();
        }

        return $date->format($format);
    }

    /**
     * @param \DateTime|null $date
     * @return string
     * @throws \Exception
     */
    protected  function getWeekKey(\DateTime $date = null)
    {
        if (!($date instanceof \DateTime)) {
            $date = new \DateTime();
        }

        return Week::createFirstDate($date)->format('Y-m-d');
    }
}