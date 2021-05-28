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

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\Base\NodeInterface;

class RowList extends AbstractImmutable implements RowListInterface
{
    /**
     * @param int $index
     * @return TRInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var TRInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return TRInterface
     * @throws \Exception
    */
    public function getFirst()
    {
        /** @var TRInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return TRInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var TRInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return TRInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var TRInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return TRInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var TRInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return TRInterface[]
     */
    public function getItems()
    {
        /** @var TRInterface[] $child */
        $child = parent::getItems();

        return $child;
    }

    /**
     * @param TRInterface|null $row
     * @return static
     */
    public function addRow(TRInterface $row = null)
    {
        $row = ($row instanceof TRInterface) ? $row : $this->createRow();

        $this->add($row);

        return $this;
    }

    /**
     * @param int $index
     * @param TRInterface|null $row
     * @return static
     */
    public function insertRow(int $index, TRInterface $row = null)
    {
        $row = ($row instanceof TRInterface) ? $row : $this->createRow();

        $this->insert($index, $row);

        return $this;
    }

    /**
     * @param int $rowIndex
     * @param string $content
     * @param bool $header
     * @return static
     * @throws \Exception
     */
    public function addCell(int $rowIndex, $content = '', bool $header = false)
    {
        if (!($this->get($rowIndex) instanceof TRInterface)) {
            $this->insertRow($rowIndex);
        }

        $row = $this->get($rowIndex);
        $row->getChildNodes()->createAndAddCell($content, $header);

        return $this;
    }

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @param mixed $content
     * @param bool $header
     * @return static
     * @throws \Exception
     */
    public function insertCell(int $rowIndex, int $cellIndex, $content = '', bool $header = false)
    {
        if (!($this->get($rowIndex) instanceof TRInterface)) {
            $this->insertRow($rowIndex);
        }

        $row = $this->get($rowIndex);
        $row->getChildNodes()->createAndInsertCell($cellIndex, $content, $header);

        return $this;
    }

    /**
     * @return TRInterface
     */
    protected function createRow()
    {
        return $this->getGiServiceLocator()->getDOMFactory()->createTR();
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