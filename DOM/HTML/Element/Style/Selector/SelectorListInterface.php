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
namespace GI\DOM\HTML\Element\Style\Selector;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\Base\NodeInterface;

interface SelectorListInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return SelectorInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return SelectorInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return SelectorInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return SelectorInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return SelectorInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return SelectorInterface[]
     */
    public function getItems();

    /**
     * @param SelectorInterface $selector
     * @return static
     */
    public function addSelector(SelectorInterface $selector);

    /**
     * @param string $selector
     * @param array $style
     * @return static
     * @throws \Exception
     */
    public function createAndAddSelector(string $selector, array $style);

    /**
     * @param int $index
     * @param SelectorInterface $selector
     * @return static
     */
    public function insertSelector(int $index, SelectorInterface $selector);

    /**
     * @param int $index
     * @param string $selector
     * @param array $style
     * @return static
     * @throws \Exception
     */
    public function createAndInsertSelector(int $index, string $selector, array $style);

    /**
     * @return static
     */
    public function clean();
}