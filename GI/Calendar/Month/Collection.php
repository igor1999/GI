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
namespace GI\Calendar\Month;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Collection implements CollectionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var MonthInterface[]
     */
    private $items = [];


    /**
     * Collection constructor.
     * @param \DateTime $firstDate
     * @param \DateTime $lastDate
     * @throws \Exception
     */
    public function __construct(\DateTime $firstDate, \DateTime $lastDate)
    {
        $currentMonth = $this->createMonth($firstDate);
        $lastMonth    = $this->createMonth($lastDate);

        $i = 1;

        while (!$currentMonth->isFutureFor($lastMonth)) {
            $this->items[$i] = $currentMonth;
            $currentMonth = $currentMonth->getNext();
            $i += 1;
        }
    }

    /**
     * @param \DateTime $date
     * @return MonthInterface
     */
    protected function createMonth(\DateTime $date)
    {
        return $this->giGetCalendarFactory()->getMonth($date);
    }

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return isset($this->items[$index]);
    }

    /**
     * @param int $index
     * @return MonthInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->giThrowNotInScopeException($index);
        }

        return $this->items[$index];
    }

    /**
     * @return MonthInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        return $this->get(1);
    }

    /**
     * @return MonthInterface
     * @throws \Exception
     */
    public function getLast()
    {
        return $this->get($this->getLength());
    }

    /**
     * @return MonthInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param MonthInterface $month
     * @return bool|int
     */
    public function find(MonthInterface $month)
    {
        $f = function(MonthInterface $item) use ($month)
        {
            return $item->contains($month);
        };
        $items   = array_filter($this->items, $f);
        $indexes = array_keys($items);

        return empty($items) ? false : array_shift($indexes);
    }
}