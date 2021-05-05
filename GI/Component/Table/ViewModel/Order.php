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
    /**
     * @var string
     */
    private $criteria = '';

    /**
     * @var string
     */
    private $direction = 0;


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
     * @extract
     * @return string
     */
    public function getCriteria()
    {
        return $this->criteria;
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
     * @param string $criteria
     * @return static
     */
    public function setCriteriaIfEmpty(string $criteria)
    {
        if (empty($this->criteria)) {
            $this->setCriteria($criteria);
        }

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
     * @hydrate
     * @param int $direction
     * @return static
     */
    public function setDirection(int $direction)
    {
        $this->direction = (int)$direction;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDirectionAsBool()
    {
        return (bool)$this->direction;
    }
}