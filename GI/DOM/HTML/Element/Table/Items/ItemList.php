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
namespace GI\DOM\HTML\Element\Table\Items;

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\HTML\Element\Table\Part\TBody\TBodyInterface;
use GI\DOM\HTML\Element\Table\Part\TFooter\TFooterInterface;
use GI\DOM\HTML\Element\Table\Part\THead\THeadInterface;
use GI\DOM\HTML\Element\Table\Row\TRInterface;
use GI\DOM\HTML\Element\Table\Part\PartInterface;
use GI\DOM\Base\NodeInterface;

class ItemList extends AbstractImmutable implements ItemListInterface
{
    /**
     * @param int $index
     * @return ItemInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var ItemInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var ItemInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var ItemInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return ItemInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var ItemInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return ItemInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var ItemInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return TRInterface[]
     */
    public function getRows()
    {
        $rows = [];

        foreach ($this->getItems() as $item) {
            if ($item instanceof PartInterface) {
                $rows = array_merge($rows, $item->getChildNodes()->getItems());
            } else {
                $rows[] = $item;
            }
        }

        return $rows;
    }

    /**
     * @return ItemInterface[]
     */
    public function getItems()
    {
        /** @var ItemInterface[] $child */
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
     * @return TRInterface
     */
    protected function createRow()
    {
        return $this->getGiServiceLocator()->getDOMFactory()->createTR();
    }

    /**
     * @param TBodyInterface|null $tbody
     * @return static
     */
    public function addTBody(TBodyInterface $tbody = null)
    {
        $tbody = ($tbody instanceof TBodyInterface) ? $tbody : $this->createTBody();

        $this->add($tbody);

        return $this;
    }

    /**
     * @param int $index
     * @param TBodyInterface|null $tbody
     * @return static
     */
    public function insertTBody(int $index, TBodyInterface $tbody = null)
    {
        $tbody = ($tbody instanceof TBodyInterface) ? $tbody : $this->createTBody();

        $this->insert($index, $tbody);

        return $this;
    }

    /**
     * @return TBodyInterface
     */
    protected function createTBody()
    {
        return $this->getGiServiceLocator()->getDOMFactory()->createTBody();
    }

    /**
     * @param THeadInterface|null $thead
     * @return static
     */
    public function addTHead(THeadInterface $thead = null)
    {
        $thead = ($thead instanceof THeadInterface) ? $thead : $this->createTHead();

        $this->add($thead);

        return $this;
    }

    /**
     * @param int $index
     * @param THeadInterface|null $thead
     * @return static
     */
    public function insertTHead(int $index, THeadInterface $thead = null)
    {
        $thead = ($thead instanceof THeadInterface) ? $thead : $this->createTHead();

        $this->insert($index, $thead);

        return $this;
    }

    /**
     * @return THeadInterface
     */
    protected function createTHead()
    {
        return $this->getGiServiceLocator()->getDOMFactory()->createTHead();
    }

    /**
     * @param TFooterInterface|null $tfooter
     * @return static
     */
    public function addTFooter(TFooterInterface $tfooter = null)
    {
        $tfooter = ($tfooter instanceof TFooterInterface) ? $tfooter : $this->createTFooter();

        $this->add($tfooter);

        return $this;
    }

    /**
     * @param int $index
     * @param TFooterInterface|null $tfooter
     * @return static
     */
    public function insertTFooter(int $index, TFooterInterface $tfooter = null)
    {
        $tfooter = ($tfooter instanceof TFooterInterface) ? $tfooter : $this->createTFooter();

        $this->insert($index, $tfooter);

        return $this;
    }

    /**
     * @return TFooterInterface
     */
    protected function createTFooter()
    {
        return $this->getGiServiceLocator()->getDOMFactory()->createTFooter();
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