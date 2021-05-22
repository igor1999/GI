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

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\Filter\Simple\DateTime\Date\DefaultEmptyInterface as DateEmptyInterface;
use GI\Filter\Simple\DateTime\Date\DefaultTodayInterface as DateTodayInterface;
use GI\Filter\Simple\DateTime\Date\DefaultNullInterface as DateNullInterface;
use GI\Filter\Simple\DateTime\DateHourMinute\DefaultEmptyInterface as DateHourMinuteEmptyInterface;
use GI\Filter\Simple\DateTime\DateHourMinute\DefaultTodayInterface as DateHourMinuteTodayInterface;
use GI\Filter\Simple\DateTime\DateHourMinute\DefaultNullInterface as DateHourMinuteNullInterface;
use GI\Filter\Simple\DateTime\DateTime\DefaultEmptyInterface as DateTimeEmptyInterface;
use GI\Filter\Simple\DateTime\DateTime\DefaultTodayInterface as DateTimeTodayInterface;
use GI\Filter\Simple\DateTime\DateTime\DefaultNullInterface as DateTimeNullInterface;
use GI\Filter\Simple\DateTime\HourMinute\DefaultEmptyInterface as HourMinuteEmptyInterface;
use GI\Filter\Simple\DateTime\HourMinute\DefaultTodayInterface as HourMinuteTodayInterface;
use GI\Filter\Simple\DateTime\HourMinute\DefaultNullInterface as HourMinuteNullInterface;
use GI\Filter\Simple\DateTime\Time\DefaultEmptyInterface as TimeEmptyInterface;
use GI\Filter\Simple\DateTime\Time\DefaultTodayInterface as TimeTodayInterface;
use GI\Filter\Simple\DateTime\Time\DefaultNullInterface as TimeNullInterface;
use GI\Filter\Simple\DateTime\Year\DefaultEmptyInterface as YearEmptyInterface;
use GI\Filter\Simple\DateTime\Year\DefaultTodayInterface as YearTodayInterface;
use GI\Filter\Simple\DateTime\Year\DefaultNullInterface as YearNullInterface;
use GI\Filter\Simple\DateTime\YearMonth\DefaultEmptyInterface as YearMonthEmptyInterface;
use GI\Filter\Simple\DateTime\YearMonth\DefaultTodayInterface as YearMonthTodayInterface;
use GI\Filter\Simple\DateTime\YearMonth\DefaultNullInterface as YearMonthNullInterface;

use GI\Filter\Container\Chain\ChainInterface;
use GI\Filter\Container\Recursive\RecursiveInterface;

/**
 * Interface FactoryInterface
 * @package GI\Filter\Factory
 *
 * @method DateEmptyInterface createDateEmpty()
 * @method DateTodayInterface createDateToday()
 * @method DateNullInterface createDateNull()
 * @method DateHourMinuteEmptyInterface createDateHourMinuteEmpty()
 * @method DateHourMinuteTodayInterface createDateHourMinuteToday()
 * @method DateHourMinuteNullInterface createDateHourMinuteNull()
 * @method DateTimeEmptyInterface createDateTimeEmpty()
 * @method DateTimeTodayInterface createDateTimeToday()
 * @method DateTimeNullInterface createDateTimeNull()
 * @method HourMinuteEmptyInterface createHourMinuteEmpty()
 * @method HourMinuteTodayInterface createHourMinuteToday()
 * @method HourMinuteNullInterface createHourMinuteNull()
 * @method TimeEmptyInterface createTimeEmpty()
 * @method TimeTodayInterface createTimeToday()
 * @method TimeNullInterface createTimeNull()
 * @method YearEmptyInterface createYearEmpty()
 * @method YearTodayInterface createYearToday()
 * @method YearNullInterface createYearNull()
 * @method YearMonthEmptyInterface createYearMonthEmpty()
 * @method YearMonthTodayInterface createYearMonthToday()
 * @method YearMonthNullInterface createYearMonthNull()
 *
 * @method ChainInterface createChain(array $contents = [])
 * @method RecursiveInterface createRecursive(array $contents = [])
 */
interface FactoryInterface extends BaseInterface
{

}