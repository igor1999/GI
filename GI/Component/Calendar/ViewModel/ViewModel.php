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
namespace GI\Component\Calendar\ViewModel;

use GI\ViewModel\AbstractViewModel;
use GI\Component\Calendar\ViewModel\Filter\Filter;

use GI\Component\Calendar\ViewModel\Filter\FilterInterface;

/**
 * Class ViewModel
 * @package GI\Component\Calendar\ViewModel
 *
 * @method array getMonthName()
 */
class ViewModel extends AbstractViewModel implements ViewModelInterface
{
    /**
     * @var string
     */
    private $month = '';

    /**
     * @var FilterInterface
     */
    private $filter;


    /**
     * ViewModel constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->filter = $this->giGetDi(FilterInterface::class, Filter::class);

        $this->setViewModelName('calendar');

        $this->month = date('Y-m');
    }

    /**
     * @extract
     * @return string
     */
    protected function getMonth()
    {
        return $this->month;
    }

    /**
     * @hydrate
     * @param string $month
     * @return static
     */
    protected function setMonth(string $month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getMonthAsDateTime()
    {
        return new \DateTime($this->month);
    }

    /**
     * @return FilterInterface
     */
    public function getFilter()
    {
        return $this->filter;
    }
}