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

use GI\Filter\Simple\DateTime\Date\Date;
use GI\Filter\Simple\DateTime\DateHourMinute\DateHourMinute;
use GI\Filter\Simple\DateTime\DateTime\DateTime;
use GI\Filter\Simple\DateTime\HourMinute\HourMinute;
use GI\Filter\Simple\DateTime\Time\Time;
use GI\Filter\Simple\DateTime\Year\Year;
use GI\Filter\Simple\DateTime\YearMonth\YearMonth;

use GI\Filter\Container\Chain\Chain;
use GI\Filter\Container\Recursive\Recursive;


use GI\Filter\FilterInterface;

use GI\Filter\Simple\DateTime\Date\DateInterface;
use GI\Filter\Simple\DateTime\DateHourMinute\DateHourMinuteInterface;
use GI\Filter\Simple\DateTime\DateTime\DateTimeInterface;
use GI\Filter\Simple\DateTime\HourMinute\HourMinuteInterface;
use GI\Filter\Simple\DateTime\Time\TimeInterface;
use GI\Filter\Simple\DateTime\Year\YearInterface;
use GI\Filter\Simple\DateTime\YearMonth\YearMonthInterface;

use GI\Filter\Container\Chain\ChainInterface;
use GI\Filter\Container\Recursive\RecursiveInterface;

/**
 * Class Factory
 * @package GI\Filter\Factory
 *
 * @method DateInterface createDate()
 * @method DateHourMinuteInterface createDateHourMinute()
 * @method DateTimeInterface createDateTime()
 * @method HourMinuteInterface createHourMinute()
 * @method TimeInterface createTime()
 * @method YearInterface createYear()
 * @method YearMonthInterface createYearMonth()
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

        $this->set(Date::class)
            ->set(DateHourMinute::class)
            ->set(DateTime::class)
            ->set(HourMinute::class)
            ->set(Time::class)
            ->set(Year::class)
            ->set(YearMonth::class)

            ->set(Chain::class)
            ->set(Recursive::class);
    }
}