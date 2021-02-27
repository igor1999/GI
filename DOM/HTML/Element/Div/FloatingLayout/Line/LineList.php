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
namespace GI\DOM\HTML\Element\Div\FloatingLayout\Line;

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Cell\CellInterface;

class LineList extends AbstractImmutable implements LineListInterface
{
    /**
     * @param int $index
     * @return LineInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var LineInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return LineInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var LineInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return LineInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var LineInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return LineInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var LineInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return LineInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var LineInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return LineInterface[]
     */
    public function getItems()
    {
        /** @var LineInterface[] $child */
        $child = parent::getItems();

        return $child;
    }

    /**
     * @param LineInterface|null $line
     * @return static
     */
    public function addLine(LineInterface $line = null)
    {
        $line = ($line instanceof LineInterface) ? $line : $this->createLine();

        $this->add($line);

        return $this;
    }

    /**
     * @param int $index
     * @param LineInterface|null $line
     * @return static
     */
    public function insertLine(int $index, LineInterface $line = null)
    {
        $line = ($line instanceof LineInterface) ? $line : $this->createLine();

        $this->insert($index, $line);

        return $this;
    }

    /**
     * @return LineInterface
     */
    protected function createLine()
    {
        return $this->giGetDOMFactory()->createLine();
    }

    /**
     * @return static
     */
    public function clean()
    {
        parent::clean();

        return $this;
    }

    /**
     * @param int $lineIndex
     * @param CellInterface $cell
     * @return static
     * @throws \Exception
     */
    public function addCell(int $lineIndex, CellInterface $cell)
    {
        if (!$this->has($lineIndex)) {
            $this->addLine();
        }

        $this->get($lineIndex)->getChildNodes()->addCell($cell);

        return $this;
    }

    /**
     * @param int $lineIndex
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function createAndAddCell(int $lineIndex, $content = '', bool $left = true)
    {
        if (!$this->has($lineIndex)) {
            $this->addLine();
        }

        $this->get($lineIndex)->getChildNodes()->createAndAddCell($content, $left);

        return $this;
    }

    /**
     * @param int $lineIndex
     * @param int $cellIndex
     * @param CellInterface $cell
     * @return static
     * @throws \Exception
     */
    public function insertCell(int $lineIndex, int $cellIndex, CellInterface $cell)
    {
        if (!$this->has($lineIndex)) {
            $this->insertLine($lineIndex);
        }

        $this->get($lineIndex)->getChildNodes()->insertCell($cellIndex, $cell);

        return $this;
    }

    /**
     * @param int $lineIndex
     * @param int $cellIndex
     * @param string|array|NodeInterface $content
     * @param bool $left
     * @return static
     * @throws \Exception
     */
    public function createAndInsertCell(int $lineIndex, int $cellIndex, $content = '', bool $left = true)
    {
        if (!$this->has($lineIndex)) {
            $this->insertLine($lineIndex);
        }

        $this->get($lineIndex)->getChildNodes()->createAndInsertCell($cellIndex, $content, $left);

        return $this;
    }

    /**
     * @param int $lineIndex
     * @param int $cellIndex
     * @return bool
     * @throws \Exception
     */
    public function removeCell(int $lineIndex, int $cellIndex)
    {
        $result = $this->has($lineIndex);

        if ($result) {
            $result = $this->get($lineIndex)->getChildNodes()->remove($cellIndex);

            if (empty($this->get($lineIndex)->getChildNodes()->getItems())) {
                $this->remove($lineIndex);
            }
        }

        return $result;
    }
}