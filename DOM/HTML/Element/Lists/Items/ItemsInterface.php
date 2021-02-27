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
namespace GI\DOM\HTML\Element\Lists\Items;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Lists\Items\LI\LIInterface;

interface ItemsInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return LIInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return LIInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return LIInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return LIInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return LIInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return LIInterface[]
     */
    public function getItems();

    /**
     * @param LIInterface $item
     * @return static
     */
    public function addItem(LIInterface $item);

    /**
     * @param string $text
     * @return static
     */
    public function addTextItem(string $text = '');

    /**
     * @param int $index
     * @param LIInterface $item
     * @return static
     */
    public function insertItem(int $index, LIInterface $item);

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertTextItem(int $index, string $text = '');

    /**
     * @return static
     */
    public function clean();
}