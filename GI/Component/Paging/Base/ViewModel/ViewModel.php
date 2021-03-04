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
namespace GI\Component\Paging\Base\ViewModel;

use GI\ViewModel\AbstractViewModel as Base;

/**
 * Class AbstractViewModel
 * @package GI\Component\Paging\Base\ViewModel
 *
 * @method array getEntriesProPageName()
 * @method string renderEntriesProPageName()
 * @method array getSelectedPageName()
 * @method string renderSelectedPageName()
 */
class ViewModel extends Base implements ViewModelInterface
{
    /**
     * @var int
     */
    private $entriesProPage;

    /**
     * @var int
     */
    private $selectedPage = 1;


    /**
     * ViewModel constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->setViewModelName('paging');
    }

    /**
     * @extract
     * @return int
     */
    public function getEntriesProPage()
    {
        return $this->entriesProPage;
    }

    /**
     * @hydrate
     * @param mixed $entriesProPage
     * @return static
     */
    protected function setEntriesProPage($entriesProPage)
    {
        $this->entriesProPage = (int)$entriesProPage;

        return $this;
    }

    /**
     * @extract
     * @return int
     */
    public function getSelectedPage()
    {
        return $this->selectedPage;
    }

    /**
     * @hydrate
     * @param mixed $selectedPage
     * @return static
     */
    protected function setSelectedPage($selectedPage)
    {
        $this->selectedPage = (int)$selectedPage;

        return $this;
    }
}