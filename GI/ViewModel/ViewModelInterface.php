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
namespace GI\ViewModel;

use GI\Pattern\ArrayExchange\ArrayExchangeInterface;
use GI\Filter\Container\Recursive\RecursiveInterface as FilterRecursiveInterface;
use GI\Validator\Container\Recursive\RecursiveInterface as ValidatorRecursiveInterface;

interface ViewModelInterface extends ArrayExchangeInterface
{
    /**
     * @return bool
     */
    public function hasViewModelParent();

    /**
     * @return static
     */
    public function getViewModelParent();

    /**
     * @param ViewModelInterface $parent
     * @return static
     */
    public function setViewModelParent(ViewModelInterface $parent);

    /**
     * @return string
     */
    public function getViewModelName();

    /**
     * @param string $name
     * @return static
     */
    public function setViewModelName(string $name);

    /**
     * @return array
     */
    public function getViewModelFullName();

    /**
     * @param string $member
     * @return array
     */
    public function getMemberFullName(string $member);

    /**
     * @param string $member
     * @return string
     * @throws \Exception
     */
    public function renderMemberFullName(string $member);

    /**
     * @return FilterRecursiveInterface
     */
    public function getFilter();

    /**
     * @return static
     * @throws \Exception
     */
    public function filter();

    /**
     * @return static
     * @throws \Exception
     */
    public function setFilterToParent();

    /**
     * @return ValidatorRecursiveInterface
     */
    public function getValidator();

    /**
     * @return bool
     */
    public function validate();

    /**
     * @return static
     * @throws \Exception
     */
    public function setValidatorToParent();

    /**
     * @return static
     * @throws \Exception
     */
    public function setFilterAndValidatorToParent();
}