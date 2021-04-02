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
namespace GI\DOM\HTML\Element\Table;

use GI\DOM\HTML\Element\ContainerElementInterface;
use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Table\Items\ItemListInterface;
use GI\DOM\HTML\Element\Table\Row\TRInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;

interface TableInterface extends ContainerElementInterface
{
    /**
     * @return ItemListInterface
     */
    public function getChildNodes();

    /**
     * @param int $numberOfRows
     * @param int $numberOfCells
     * @param bool $withHeader
     * @return static
     * @throws \Exception
     */
    public function build(int $numberOfRows, int $numberOfCells, bool $withHeader = false);

    /**
     * @param int $index
     * @return TRInterface
     */
    public function getRow(int $index);

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @return TDInterface|THInterface
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
}