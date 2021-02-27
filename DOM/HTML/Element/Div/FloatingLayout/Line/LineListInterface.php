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
namespace GI\DOM\HTML\Element\Div\FloatingLayout\Line;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Cell\CellInterface;

interface LineListInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return LineInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return LineInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return LineInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return LineInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return LineInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return LineInterface[]
     */
    public function getItems();

    /**
     * @param LineInterface|null $line
     * @return static
     */
    public function addLine(LineInterface $line = null);

    /**
     * @param int $index
     * @param LineInterface|null $line
     * @return static
     */
    public function insertLine(int $index, LineInterface $line = null);

    /**
     * @return static
     */
    public function clean();

    /**
     * @param int $lineIndex
     * @param CellInterface $cell
     * @return static
     * @throws \Exception
     */
    public function addCell(int $lineIndex, CellInterface $cell);

    /**
     * @param int $lineIndex
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function createAndAddCell(int $lineIndex, $content = '', bool $left = true);

    /**
     * @param int $lineIndex
     * @param int $cellIndex
     * @param CellInterface $cell
     * @return static
     * @throws \Exception
     */
    public function insertCell(int $lineIndex, int $cellIndex, CellInterface $cell);

    /**
     * @param int $lineIndex
     * @param int $cellIndex
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function createAndInsertCell(int $lineIndex, int $cellIndex, $content = '', bool $left = true);

    /**
     * @param int $lineIndex
     * @param int $cellIndex
     * @return bool
     * @throws \Exception
     */
    public function removeCell(int $lineIndex, int $cellIndex);
}