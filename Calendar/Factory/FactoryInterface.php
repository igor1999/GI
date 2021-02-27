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

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\Calendar\Day\DayInterface;
use GI\Calendar\Day\CollectionInterface as DayCollectionInterface;
use GI\Calendar\Week\WeekInterface;
use GI\Calendar\Week\CollectionInterface as WeekCollectionInterface;
use GI\Calendar\Month\MonthInterface;
use GI\Calendar\Month\CollectionInterface as MonthCollectionInterface;
use GI\Calendar\Year\YearInterface;
use GI\Calendar\Year\CollectionInterface as YearCollectionInterface;

/**
 * Interface FactoryInterface
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
interface FactoryInterface extends BaseInterface
{

}