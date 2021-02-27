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
namespace GI\DOM\HTML\Element\DL\Items;

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\DL\Items\DD\DDInterface;
use GI\DOM\HTML\Element\DL\Items\DT\DTInterface;

class Items extends AbstractImmutable implements ItemsInterface
{
    /**
     * @param int $index
     * @return DTInterface|DDInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var DTInterface|DDInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return DTInterface|DDInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var DTInterface|DDInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return DTInterface|DDInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var DTInterface|DDInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return DTInterface|DDInterface|null
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var DTInterface|DDInterface|null $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return DTInterface|DDInterface|null
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var DTInterface|DDInterface|null $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return DTInterface[]|DDInterface[]
     */
    public function getItems()
    {
        /** @var DTInterface[]|DDInterface[] $children */
        $children = parent::getItems();

        return $children;
    }

    /**
     * @param DTInterface $dt
     * @return static
     */
    public function addDT(DTInterface $dt)
    {
        $this->add($dt);

        return $this;
    }

    /**
     * @param DDInterface $dd
     * @return static
     */
    public function addDD(DDInterface $dd)
    {
        $this->add($dd);

        return $this;
    }

    /**
     * @param string $text
     * @return static
     */
    public function addDTText(string $text = '')
    {
        $this->addDT($this->createDT($text));

        return $this;
    }

    /**
     * @param string $text
     * @return static
     */
    public function addDDText(string $text = '')
    {
        $this->addDD($this->createDD($text));

        return $this;
    }

    /**
     * @param int $index
     * @param DTInterface $dt
     * @return static
     */
    public function insertDT(int $index, DTInterface $dt)
    {
        $this->insert($index, $dt);

        return $this;
    }

    /**
     * @param int $index
     * @param DDInterface $dd
     * @return static
     */
    public function insertDD(int $index, DDInterface $dd)
    {
        $this->insert($index, $dd);

        return $this;
    }

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertDTText(int $index, string $text = '')
    {
        $this->insertDT($index, $this->createDT($text));

        return $this;
    }

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertDDText(int $index, string $text = '')
    {
        $this->insertDD($index, $this->createDD($text));

        return $this;
    }

    /**
     * @param string|number $text
     * @return DTInterface
     */
    protected function createDT(string $text)
    {
        return $this->giGetDOMFactory()->createDT($text);
    }

    /**
     * @param string|number $text
     * @return DDInterface
     */
    protected function createDD(string $text)
    {
        return $this->giGetDOMFactory()->createDD($text);
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