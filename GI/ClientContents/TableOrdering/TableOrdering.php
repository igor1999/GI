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
namespace GI\ClientContents\TableOrdering;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class TableOrdering implements TableOrderingInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $criteria = '';

    /**
     * @var bool
     */
    private $bothDirections = true;

    /**
     * @var bool
     */
    private $ordering;


    /**
     * TableHeader constructor.
     * @param string $criteria
     * @param bool $bothDirections
     */
    public function __construct(string $criteria, bool $bothDirections)
    {
        $this->criteria       = $criteria;
        $this->bothDirections = $bothDirections;
    }

    /**
     * @return string
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @return bool
     */
    public function isBothDirections()
    {
        return $this->bothDirections;
    }

    /**
     * @return bool|null
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param string $orderCriteria
     * @param bool $orderDirection
     * @return static
     */
    public function setOrdering(string $orderCriteria, bool $orderDirection)
    {
        if ($this->criteria != $orderCriteria) {
            $this->ordering = null;
        } else {
            $this->ordering = ($orderDirection || !$this->bothDirections);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isAscendant()
    {
        return $this->ordering === true;
    }

    /**
     * @return bool
     */
    public function isDescendant()
    {
        return $this->ordering === false;
    }

    /**
     * @return bool
     */
    public function isNone()
    {
        return !is_bool($this->ordering);
    }

    /**
     * @return bool
     */
    public function getNextDirection()
    {
        return !$this->bothDirections || !$this->isAscendant();
    }

    /**
     * @return string
     */
    public function getNextDirectionAsString()
    {
        return $this->getNextDirection() ? '1' : '0';
    }
}