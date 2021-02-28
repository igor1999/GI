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
namespace GI\DOM\HTML\Element\TextArea\Nodes;

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\Base\NodeInterface;
use GI\DOM\Base\TextNode\TextNodeInterface;

class NodesList extends AbstractImmutable implements NodesListInterface
{
    /**
     * @param int $index
     * @return TextNodeInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var TextNodeInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return TextNodeInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var TextNodeInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return TextNodeInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var TextNodeInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return TextNodeInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var TextNodeInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return TextNodeInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var TextNodeInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return TextNodeInterface[]
     */
    public function getItems()
    {
        /** @var TextNodeInterface[] $children */
        $children = parent::getItems();

        return $children;
    }

    /**
     * @param string $text
     * @return static
     */
    public function setText(string $text = '')
    {
        try {
            $this->set($text)->get(0)->getEscaper()->setOn(false);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param string $text
     * @return static
     */
    public function addText(string $text = '')
    {
        try {
            $this->add($text)->getLast()->getEscaper()->setOn(false);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertText(int $index, string $text = '')
    {
        try {
            $this->insert($index, $text)->get($index)->getEscaper()->setOn(false);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @return static
     */
    public function clean()
    {
        parent::clean();

        return $this;
    }
}