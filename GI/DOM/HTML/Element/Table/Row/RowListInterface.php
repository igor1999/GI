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
namespace GI\DOM\HTML\Element\Table\Row;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\Base\NodeInterface;

interface RowListInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return TRInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return TRInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return TRInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return TRInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return TRInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return TRInterface[]
     */
    public function getItems();

    /**
     * @param TRInterface|null $row
     * @return static
     */
    public function addRow(TRInterface $row = null);

    /**
     * @param int $index
     * @param TRInterface|null $row
     * @return static
     */
    public function insertRow(int $index, TRInterface $row = null);

    /**
     * @param int $rowIndex
     * @param mixed $content
     * @param bool $header
     * @return static
     * @throws \Exception
     */
    public function addCell(int $rowIndex, $content = '', bool $header = false);

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @param mixed $content
     * @param bool $header
     * @return static
     * @throws \Exception
     */
    public function insertCell(int $rowIndex, int $cellIndex, $content = '', bool $header = false);

    /**
     * @return static
     */
    public function clean();
}