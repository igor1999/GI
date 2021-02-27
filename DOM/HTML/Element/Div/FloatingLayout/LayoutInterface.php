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
namespace GI\DOM\HTML\Element\Div\FloatingLayout;

use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Cell\CellInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Line\LineListInterface;

interface LayoutInterface extends DivInterface
{
    /**
     * @return LineListInterface
     */
    public function getChildNodes();

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
     * @return CellInterface
     * @throws \Exception
     */
    public function get(int $rowIndex, int $cellIndex);

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @param string|array|NodeInterface $contents
     * @return static
     * @throws \Exception
     */
    public function set(int $rowIndex, int $cellIndex, $contents);

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @param bool|null $left
     * @return bool
     * @throws \Exception
     */
    public function toggleCellFloat(int $rowIndex, int $cellIndex, bool $left = null);
}