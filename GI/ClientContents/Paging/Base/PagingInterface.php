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
namespace GI\ClientContents\Paging\Base;

use GI\ClientContents\Paging\Base\Context\ContextInterface;
use GI\ClientContents\Paging\Base\ShowedPages\ShowedPagesInterface;

interface PagingInterface
{
    /**
     * @return ContextInterface
     */
    public function getContext();

    /**
     * @return int
     */
    public function getEntriesTotal();

    /**
     * @return int
     */
    public function getSelectedPage();

    /**
     * @return int
     */
    public function getEntriesProPage();

    /**
     * @return int
     */
    public function getPagesTotal();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @return bool
     */
    public function isSingle();

    /**
     * @return bool
     */
    public function isMulti();

    /**
     * @return int
     */
    public function getFirstShowedEntry();

    /**
     * @return int
     */
    public function getLastShowedEntry();

    /**
     * @return bool
     */
    public function isFirst();

    /**
     * @return int
     * @throws \Exception
     */
    public function getPrevious();

    /**
     * @return bool
     */
    public function isLast();

    /**
     * @return int
     * @throws \Exception
     */
    public function getNext();

    /**
     * @return bool
     */
    public function needNaviFirst();

    /**
     * @return bool
     */
    public function needNaviLast();

    /**
     * @return bool
     */
    public function needNaviPrevious();

    /**
     * @return bool
     */
    public function needNaviNext();

    /**
     * @return ShowedPagesInterface
     */
    public function getShowedPages();
}
