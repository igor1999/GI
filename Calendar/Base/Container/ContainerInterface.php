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
namespace GI\Calendar\Base\Container;

use GI\Calendar\Day\CollectionInterface;
use GI\Calendar\Day\DayInterface;

interface ContainerInterface
{
    /**
     * @return \DateTime
     */
    public function getFirstDate();

    /**
     * @return \DateTime
     */
    public function getLastDate();

    /**
     * @return DayInterface
     */
    public function getFirstDay();

    /**
     * @return DayInterface
     */
    public function getLastDay();

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function isPastFor(ContainerInterface $unit);

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function isPastWithIntersectionFor(ContainerInterface $unit);

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function isFutureFor(ContainerInterface $unit);

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function isFutureWithIntersectionFor(ContainerInterface $unit);

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function contains(ContainerInterface $unit);

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function containedOf(ContainerInterface $unit);

    /**
     * @return CollectionInterface
     */
    public function getDays();
}