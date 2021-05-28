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

use GI\Calendar\Day\CollectionInterface as DayCollectionInterface;
use GI\Calendar\Day\DayInterface;

trait ContainerTrait
{
    /**
     * @var \DateTime
     */
    private $firstDate;

    /**
     * @var \DateTime
     */
    private $lastDate;


    /**
     * @return \DateTime
     */
    public function getFirstDate()
    {
        return clone $this->firstDate;

    }

    /**
     * @return \DateTime
     */
    public function getLastDate()
    {
        return clone $this->lastDate;
    }

    /**
     * @param \DateTime $date
     * @return DayInterface
     */
    protected function createDay(\DateTime $date)
    {
        return $this->getGiServiceLocator()->getCalendarFactory()->getDay($date);
    }

    /**
     * @return DayInterface
     */
    public function getFirstDay()
    {
        return $this->createDay($this->firstDate);

    }

    /**
     * @return DayInterface
     */
    public function getLastDay()
    {
        return $this->createDay($this->lastDate);
    }

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function isPastFor(ContainerInterface $unit)
    {
        return $this->getLastDay()->isPastFor($unit->getFirstDay());
    }

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function isPastWithIntersectionFor(ContainerInterface $unit)
    {
        $myFirstDay = $this->getFirstDay();
        $myLastDay  = $this->getLastDay();

        $hisFirstDay = $unit->getFirstDay();
        $hisLastDay  = $unit->getLastDay();

        return $myFirstDay->isPastFor($hisFirstDay)
            && !$hisFirstDay->isFutureFor($myLastDay)
            && $myLastDay->isPastFor($hisLastDay);
    }

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function isFutureFor(ContainerInterface $unit)
    {
        return $this->getFirstDay()->isFutureFor($unit->getLastDay());
    }

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function isFutureWithIntersectionFor(ContainerInterface $unit)
    {
        if ($this instanceof ContainerInterface) {
            $result = $unit->isPastWithIntersectionFor($this);
        } else {
            trigger_error(
                'This class should implement ContainerInterface: ' . static::class, E_USER_ERROR
            );
        }

        return $result;
    }

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function contains(ContainerInterface $unit)
    {
        return !$this->getFirstDay()->isFutureFor($unit->getFirstDay())
            && !$this->getLastDay()->isPastFor($unit->getLastDay());
    }

    /**
     * @param ContainerInterface $unit
     * @return bool
     */
    public function containedOf(ContainerInterface $unit)
    {
        if ($this instanceof ContainerInterface) {
            $result = $unit->contains($this);
        } else {
            trigger_error(
                'This class should implement ContainerInterface: ' . static::class, E_USER_ERROR
            );
        }

        return $result;
    }

    /**
     * @return DayCollectionInterface
     */
    public function getDays()
    {
        return $this->getGiServiceLocator()->getCalendarFactory()->getDayCollection($this->firstDate, $this->lastDate);
    }
}