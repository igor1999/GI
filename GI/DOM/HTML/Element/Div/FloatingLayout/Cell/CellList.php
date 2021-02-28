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

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\HTML\Element\Div\Float\Left\LeftInterface as FloatLeftInterface;
use GI\DOM\HTML\Element\Div\Float\Right\RightInterface as FloatRightInterface;
use GI\DOM\Base\NodeInterface;

class CellList extends AbstractImmutable implements CellListInterface
{
    const CELL_ATTRIBUTE = 'gi-cell';


    /**
     * @param int $index
     * @return CellInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var CellInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return CellInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var CellInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return CellInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var CellInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return CellInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var CellInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return CellInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var CellInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return CellInterface[]
     */
    public function getItems()
    {
        /** @var CellInterface[] $child */
        $child = parent::getItems();

        return $child;
    }

    /**
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return FloatLeftInterface|FloatRightInterface
     * @throws \Exception
     */
    protected function createCell($content = '', bool $left = true)
    {
        $cell = $left ? $this->giGetDOMFactory()->createFloatLeft() : $this->giGetDOMFactory()->createFloatRight();
        $cell->getAttributes()->setDataAttribute(static::CELL_ATTRIBUTE, '');

        $cell->getChildNodes()->set($content);

        return $cell;
    }

    /**
     * @param CellInterface $cell
     * @return static
     */
    public function addCell(CellInterface $cell)
    {
        $this->add($cell);

        return $this;
    }

    /**
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function createAndAddCell($content = '', bool $left = true)
    {
        $this->add($this->createCell($content, $left));

        return $this;
    }

    /**
     * @param int $index
     * @param CellInterface $cell
     * @return static
     */
    public function insertCell(int $index, CellInterface $cell)
    {
        $this->insert($index, $cell);

        return $this;
    }

    /**
     * @param int $index
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function createAndInsertCell(int $index, $content = '', bool $left = true)
    {
        $this->insert($index, $this->createCell($content, $left));

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