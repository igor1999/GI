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
namespace GI\DOM\HTML\Element\Form\Layouts\Base;

use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface as ElementLayoutInterface;

interface LayoutInterface
{
    /**
     * @return ElementLayoutInterface
     */
    public function getLayout();

    /**
     * @param int $rowsNumber
     * @param int $cellsNumber
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function build(int $rowsNumber, int $cellsNumber, bool $left = true);

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @param mixed $contents
     * @return static
     * @throws \Exception
     */
    public function set(int $rowIndex, int $cellIndex, $contents);
}