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
namespace GI\Component\Table\View\Widget\Template\Column;

use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\Component\Table\View\Widget\WidgetInterface;

interface ColumnInterface
{
    /**
     * @return string
     */
    public function getHeaderCellClass();

    /**
     * @param string $headerCellClass
     * @return static
     */
    public function setHeaderCellClass(string $headerCellClass);

    /**
     * @return string
     */
    public function getBodyCellClass();

    /**
     * @param string $bodyCellClass
     * @return static
     */
    public function setBodyCellClass(string $bodyCellClass);

    /**
     * @param WidgetInterface $widget
     * @param string $orderCriteria
     * @param bool $orderDirection
     * @return THInterface
     * @throws \Exception
     */
    public function createHeaderCell(WidgetInterface $widget, string $orderCriteria, bool $orderDirection);

    /**
     * @param WidgetInterface $widget
     * @param int $position
     * @param mixed $value
     * @return TDInterface
     * @throws \Exception
     */
    public function createBodyCell(WidgetInterface $widget, int $position, $value);
}