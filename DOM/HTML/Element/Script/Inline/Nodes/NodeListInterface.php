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
namespace GI\DOM\HTML\Element\Script\Inline\Nodes;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\Base\NodeInterface;

interface NodeListInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return ScriptNodeInterface[]
     */
    public function getItems();

    /**
     * @param string $node
     * @return static
     */
    public function setScript(string $node);

    /**
     * @param string $file
     * @return static
     */
    public function loadScript(string $file);

    /**
     * @param string $node
     * @return static
     */
    public function addNode(string $node);

    /**
     * @param string $file
     * @return static
     */
    public function loadAndAddNode(string $file);

    /**
     * @param int $index
     * @param string $node
     * @return static
     */
    public function insertNode(int $index, string $node);

    /**
     * @param int $index
     * @param string $file
     * @return static
     */
    public function loadAndInsertNode(int $index, string $file);
}