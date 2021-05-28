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

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;

class CellList extends AbstractImmutable implements CellListInterface
{
    /**
     * @param int $index
     * @return TDInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var TDInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return TDInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var TDInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return TDInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var TDInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return TDInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var TDInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return TDInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var TDInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return TDInterface[]
     */
    public function getItems()
    {
        /** @var TDInterface[] $child */
        $child = parent::getItems();

        return $child;
    }

    /**
     * @param TDInterface $cell
     * @return static
     */
    public function addCell(TDInterface $cell)
    {
        $this->add($cell);

        return $this;
    }

    /**
     * @param string|array|NodeInterface $content
     * @param bool $header
     * @return static
     */
    public function createAndAddCell($content = '', bool $header = false)
    {
        $this->add($this->createCell($content, $header));

        return $this;
    }

    /**
     * @param int $index
     * @param TDInterface $cell
     * @return static
     */
    public function insertCell(int $index, TDInterface $cell)
    {
        $this->insert($index, $cell);

        return $this;
    }

    /**
     * @param int $index
     * @param string|array|NodeInterface $content
     * @param bool $header
     * @return static
     */
    public function createAndInsertCell(int $index, $content = '', bool $header = false)
    {
        $this->insert($index, $this->createCell($content, $header));

        return $this;
    }

    /**
     * @param string|array|NodeInterface $content
     * @param bool $header
     * @return THInterface|TDInterface
     */
    protected function createCell($content = '', bool $header = false)
    {
        return $header
            ? $this->getGiServiceLocator()->getDOMFactory()->createTH($content)
            : $this->getGiServiceLocator()->getDOMFactory()->createTD($content);
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