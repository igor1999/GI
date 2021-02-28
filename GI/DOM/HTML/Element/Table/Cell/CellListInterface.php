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
namespace GI\DOM\HTML\Element\Table\Cell;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;

interface CellListInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return TDInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return TDInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return TDInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return TDInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return TDInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return TDInterface[]
     */
    public function getItems();

    /**
     * @param TDInterface $cell
     * @return static
     */
    public function addCell(TDInterface $cell);

    /**
     * @param string|array|NodeInterface $content
     * @param bool $header
     * @return static
     */
    public function createAndAddCell($content = '', bool $header = false);

    /**
     * @param int $index
     * @param TDInterface $cell
     * @return static
     */
    public function insertCell(int $index, TDInterface $cell);

    /**
     * @param int $index
     * @param string|array|NodeInterface $content
     * @param bool $header
     * @return static
     */
    public function createAndInsertCell(int $index, $content = '', bool $header = false);

    /**
     * @return static
     */
    public function clean();
}