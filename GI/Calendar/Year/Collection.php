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
namespace GI\Calendar\Year;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Collection implements CollectionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var YearInterface[]
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
        $currentYear = $this->createYear($firstDate);
        $lastYear    = $this->createYear($lastDate);

        $i = 1;

        while (!$currentYear->isFutureFor($lastYear)) {
            $this->items[$i] = $currentYear;
            $currentYear = $currentYear->getNext();
            $i += 1;
        }
    }

    /**
     * @param \DateTime $date
     * @return YearInterface
     */
    protected function createYear(\DateTime $date)
    {
        return $this->giGetCalendarFactory()->getYear($date);
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
     * @return YearInterface
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
     * @return YearInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        return $this->get(1);
    }

    /**
     * @return YearInterface
     * @throws \Exception
     */
    public function getLast()
    {
        return $this->get($this->getLength());
    }

    /**
     * @return YearInterface[]
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
     * @param YearInterface $year
     * @return bool|int
     */
    public function find(YearInterface $year)
    {
        $f = function(YearInterface $item) use ($year)
        {
            return $item->contains($year);
        };
        $items   = array_filter($this->items, $f);
        $indexes = array_keys($items);

        return empty($items) ? false : array_shift($indexes);
    }
}