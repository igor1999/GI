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
namespace GI\Component\Table\ViewModel;

use GI\ViewModel\AbstractViewModel;

/**
 * Class Order
 * @package GI\Component\Table\ViewModel
 *
 * @method array getCriteriaName()
 * @method string renderCriteriaName()
 * @method array getDirectionName()
 * @method string renderDirectionName()
 */
class Order extends AbstractViewModel implements OrderInterface
{
    const DEFAULT_ASCENDANT_DIRECTION  = '1';

    const DEFAULT_DESCENDANT_DIRECTION = '0';


    /**
     * @var string
     */
    private $criteria = '';

    /**
     * @var string
     */
    private $direction = self::DEFAULT_ASCENDANT_DIRECTION;

    /**
     * @var string
     */
    private $defaultCriteria = '';


    /**
     * Order constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->setViewModelName('order');
    }

    /**
     * @return string
     */
    public function getRawCriteria()
    {
        return $this->criteria;
    }

    /**
     * @extract
     * @return string
     */
    public function getCriteria()
    {
        return empty($this->criteria) ? $this->defaultCriteria : $this->criteria;
    }

    /**
     * @hydrate
     * @param string $criteria
     * @return static
     */
    public function setCriteria(string $criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * @extract
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @return bool
     */
    public function getDirectionAsBool()
    {
        return $this->direction == static::DEFAULT_ASCENDANT_DIRECTION;
    }

    /**
     * @param bool $direction
     * @return string
     */
    public function getDirectionAsString(bool $direction)
    {
        return $direction ? static::DEFAULT_ASCENDANT_DIRECTION : static::DEFAULT_DESCENDANT_DIRECTION;
    }

    /**
     * @hydrate
     * @param string $direction
     * @return static
     */
    public function setDirection(string $direction)
    {
        $this->direction = $direction == static::DEFAULT_ASCENDANT_DIRECTION
            ? $direction
            : static::DEFAULT_DESCENDANT_DIRECTION;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultCriteria()
    {
        return $this->defaultCriteria;
    }

    /**
     * @param string $defaultCriteria
     * @return static
     */
    public function setDefaultCriteria(string $defaultCriteria)
    {
        $this->defaultCriteria = $defaultCriteria;

        return $this;
    }
}