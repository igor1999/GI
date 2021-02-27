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
namespace GI\ClientContents\TableHeader\Column\Order;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Order implements OrderInterface
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
     * @var string
     */
    private $actualCriteria = '';

    /**
     * @var bool
     */
    private $actualDirection;


    /**
     * @return string
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param string $criteria
     * @return static
     */
    public function setCriteria(string $criteria = '')
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBothDirections()
    {
        return $this->bothDirections;
    }

    /**
     * @param bool $bothDirections
     * @return static
     */
    public function setBothDirections(bool $bothDirections)
    {
        $this->bothDirections = $bothDirections;

        return $this;
    }

    /**
     * @return string
     */
    public function getActualCriteria()
    {
        return $this->actualCriteria;
    }

    /**
     * @param string $attribute
     * @return static
     */
    public function setActualCriteria(string $attribute)
    {
        $this->actualCriteria = $attribute;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActualDirection()
    {
        return $this->actualDirection;
    }

    /**
     * @param bool $actualDirection
     * @return static
     */
    public function setActualDirection(bool $actualDirection)
    {
        $this->actualDirection = $actualDirection;

        return $this;
    }

    /**
     * @return bool
     */
    protected function compareCriteria()
    {
        return !empty($this->criteria) && !empty($this->actualCriteria) && ($this->criteria == $this->actualCriteria);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function getDirection()
    {
        switch (true) {
            case $this->compareCriteria() && ($this->actualDirection || !$this->bothDirections):
                $result = true;
                break;
            case $this->compareCriteria() && !$this->actualDirection && $this->bothDirections:
                $result = false;
                break;
            default;
                $result = null;
                $this->giThrowNotSetException('Direction');
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isAscendant()
    {
        try {
            $result = $this->getDirection() === true;
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isDescendant()
    {
        try {
            $result = $this->getDirection() === false;
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isNone()
    {
        try {
            $this->getDirection();
            $result = false;
        } catch (\Exception $e) {
            $result = true;
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function getNextDirection()
    {
        return !$this->bothDirections || !$this->isAscendant();
    }
}