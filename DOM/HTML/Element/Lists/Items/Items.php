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

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Lists\Items\LI\LIInterface;

class Items extends AbstractImmutable implements ItemsInterface
{
    /**
     * @param int $index
     * @return LIInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var LIInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return LIInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var LIInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return LIInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var LIInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return LIInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var LIInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return LIInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var LIInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return LIInterface[]
     */
    public function getItems()
    {
        /** @var LIInterface[] $children */
        $children = parent::getItems();

        return $children;
    }

    /**
     * @param LIInterface $item
     * @return static
     */
    public function addItem(LIInterface $item)
    {
        $this->add($item);

        return $this;
    }

    /**
     * @param string $text
     * @return static
     */
    public function addTextItem(string $text = '')
    {
        $this->addItem($this->createItem($text));

        return $this;
    }

    /**
     * @param int $index
     * @param LIInterface $item
     * @return static
     */
    public function insertItem(int $index, LIInterface $item)
    {
        $this->insert($index, $item);

        return $this;
    }

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertTextItem(int $index, string $text = '')
    {
        $this->insertItem($index, $this->createItem($text));

        return $this;
    }

    /**
     * @param string|number $text
     * @return LIInterface
     */
    protected function createItem(string $text)
    {
        return $this->giGetDOMFactory()->createLI($text);
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