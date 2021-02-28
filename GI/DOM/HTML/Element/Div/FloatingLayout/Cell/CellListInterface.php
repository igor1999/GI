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
namespace GI\DOM\HTML\Element\Div\FloatingLayout\Cell;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\Base\NodeInterface;

interface CellListInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return CellInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return CellInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return CellInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return CellInterface
     * @throws \Exception
    */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return CellInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return CellInterface[]
     */
    public function getItems();

    /**
     * @param CellInterface $cell
     * @return static
     */
    public function addCell(CellInterface $cell);

    /**
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function createAndAddCell($content = '', bool $left = true);

    /**
     * @param int $index
     * @param CellInterface $cell
     * @return static
     */
    public function insertCell(int $index, CellInterface $cell);

    /**
     * @param int $index
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function createAndInsertCell(int $index, $content = '', bool $left = true);

    /**
     * @return static
     */
    public function clean();
}