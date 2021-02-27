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
namespace GI\Filter\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\Filter\Simple\DateTime\Date\DefaultEmpty as DateEmpty;
use GI\Filter\Simple\DateTime\Date\DefaultToday as DateToday;
use GI\Filter\Simple\DateTime\DateHourMinute\DefaultEmpty as DateHourMinuteEmpty;
use GI\Filter\Simple\DateTime\DateHourMinute\DefaultToday as DateHourMinuteToday;
use GI\Filter\Simple\DateTime\DateTime\DefaultEmpty as DateTimeEmpty;
use GI\Filter\Simple\DateTime\DateTime\DefaultToday as DateTimeToday;
use GI\Filter\Simple\DateTime\HourMinute\DefaultEmpty as HourMinuteEmpty;
use GI\Filter\Simple\DateTime\HourMinute\DefaultToday as HourMinuteToday;
use GI\Filter\Simple\DateTime\Time\DefaultEmpty as TimeEmpty;
use GI\Filter\Simple\DateTime\Time\DefaultToday as TimeToday;
use GI\Filter\Simple\DateTime\Year\DefaultEmpty as YearEmpty;
use GI\Filter\Simple\DateTime\Year\DefaultToday as YearToday;
use GI\Filter\Simple\DateTime\YearMonth\DefaultEmpty as YearMonthEmpty;
use GI\Filter\Simple\DateTime\YearMonth\DefaultToday as YearMonthToday;

use GI\Filter\Container\Chain\Chain;
use GI\Filter\Container\Recursive\Recursive;


use GI\Filter\FilterInterface;

use GI\Filter\Simple\DateTime\Date\DefaultEmptyInterface as DateEmptyInterface;
use GI\Filter\Simple\DateTime\Date\DefaultTodayInterface as DateTodayInterface;
use GI\Filter\Simple\DateTime\DateHourMinute\DefaultEmptyInterface as DateHourMinuteEmptyInterface;
use GI\Filter\Simple\DateTime\DateHourMinute\DefaultTodayInterface as DateHourMinuteTodayInterface;
use GI\Filter\Simple\DateTime\DateTime\DefaultEmptyInterface as DateTimeEmptyInterface;
use GI\Filter\Simple\DateTime\DateTime\DefaultTodayInterface as DateTimeTodayInterface;
use GI\Filter\Simple\DateTime\HourMinute\DefaultEmptyInterface as HourMinuteEmptyInterface;
use GI\Filter\Simple\DateTime\HourMinute\DefaultTodayInterface as HourMinuteTodayInterface;
use GI\Filter\Simple\DateTime\Time\DefaultEmptyInterface as TimeEmptyInterface;
use GI\Filter\Simple\DateTime\Time\DefaultTodayInterface as TimeTodayInterface;
use GI\Filter\Simple\DateTime\Year\DefaultEmptyInterface as YearEmptyInterface;
use GI\Filter\Simple\DateTime\Year\DefaultTodayInterface as YearTodayInterface;
use GI\Filter\Simple\DateTime\YearMonth\DefaultEmptyInterface as YearMonthEmptyInterface;
use GI\Filter\Simple\DateTime\YearMonth\DefaultTodayInterface as YearMonthTodayInterface;

use GI\Filter\Container\Chain\ChainInterface;
use GI\Filter\Container\Recursive\RecursiveInterface;

/**
 * Class Factory
 * @package GI\Filter\Factory
 *
 * @method DateEmptyInterface createDateEmpty()
 * @method DateTodayInterface createDateToday()
 * @method DateHourMinuteEmptyInterface createDateHourMinuteEmpty()
 * @method DateHourMinuteTodayInterface createDateHourMinuteToday()
 * @method DateTimeEmptyInterface createDateTimeEmpty()
 * @method DateTimeTodayInterface createDateTimeToday()
 * @method HourMinuteEmptyInterface createHourMinuteEmpty()
 * @method HourMinuteTodayInterface createHourMinuteToday()
 * @method TimeEmptyInterface createTimeEmpty()
 * @method TimeTodayInterface createTimeToday()
 * @method YearEmptyInterface createYearEmpty()
 * @method YearTodayInterface createYearToday()
 * @method YearMonthEmptyInterface createYearMonthEmpty()
 * @method YearMonthTodayInterface createYearMonthToday()
 *
 * @method ChainInterface createChain(array $contents = [])
 * @method RecursiveInterface createRecursive(array $contents = [])
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(FilterInterface::class);

        $this->setNamed('DateEmpty', DateEmpty::class)
            ->setNamed('DateToday', DateToday::class)
            ->setNamed('DateHourMinuteEmpty', DateHourMinuteEmpty::class)
            ->setNamed('DateHourMinuteToday', DateHourMinuteToday::class)
            ->setNamed('DateTimeEmpty', DateTimeEmpty::class)
            ->setNamed('DateTimeToday', DateTimeToday::class)
            ->setNamed('HourMinuteEmpty', HourMinuteEmpty::class)
            ->setNamed('HourMinuteToday', HourMinuteToday::class)
            ->setNamed('TimeEmpty', TimeEmpty::class)
            ->setNamed('TimeToday', TimeToday::class)
            ->setNamed('YearEmpty', YearEmpty::class)
            ->setNamed('YearToday', YearToday::class)
            ->setNamed('YearMonthEmpty', YearMonthEmpty::class)
            ->setNamed('YearMonthToday', YearMonthToday::class)
            ->set(Chain::class)
            ->set(Recursive::class);
    }
}