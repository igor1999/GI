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

use GI\ViewModel\ViewModelInterface as BaseInterface;

/**
 * Interface OrderInterface
 * @package GI\Component\Table\ViewModel
 *
 * @method array getCriteriaName()
 * @method string renderCriteriaName()
 * @method array getDirectionName()
 * @method string renderDirectionName()
 */
interface OrderInterface extends BaseInterface
{
    /**
     * @return string
     */
    public function getRawCriteria();

    /**
     * @return string
     */
    public function getCriteria();

    /**
     * @param string $criteria
     * @return static
     */
    public function setCriteria(string $criteria);

    /**
     * @extract
     * @return string
     */
    public function getDirection();

    /**
     * @return bool
     */
    public function getDirectionAsBool();

    /**
     * @param bool $direction
     * @return string
     */
    public function getDirectionAsString(bool $direction);

    /**
     * @hydrate
     * @param string $direction
     * @return static
     */
    public function setDirection(string $direction);

    /**
     * @return string
     */
    public function getDefaultCriteria();

    /**
     * @param string $defaultCriteria
     * @return static
     */
    public function setDefaultCriteria(string $defaultCriteria);
}