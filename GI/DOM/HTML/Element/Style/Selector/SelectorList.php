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

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\Base\NodeInterface;

class SelectorList extends AbstractImmutable implements SelectorListInterface
{
    /**
     * @param int $index
     * @return SelectorInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var SelectorInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return SelectorInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var SelectorInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return SelectorInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var SelectorInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return SelectorInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var SelectorInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return SelectorInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var SelectorInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return SelectorInterface[]
     */
    public function getItems()
    {
        /** @var SelectorInterface[] $children */
        $children = parent::getItems();

        return $children;
    }

    /**
     * @param SelectorInterface $selector
     * @return static
     */
    public function addSelector(SelectorInterface $selector)
    {
        $this->add($selector);

        return $this;
    }

    /**
     * @param string $selector
     * @param array $style
     * @return static
     * @throws \Exception
     */
    public function createAndAddSelector(string $selector, array $style)
    {
        $this->addSelector($this->createSelector($selector, $style));

        return $this;
    }

    /**
     * @param int $index
     * @param SelectorInterface $selector
     * @return static
     */
    public function insertSelector(int $index, SelectorInterface $selector)
    {
        $this->insert($index, $selector);

        return $this;
    }

    /**
     * @param int $index
     * @param string $selector
     * @param array $style
     * @return static
     * @throws \Exception
     */
    public function createAndInsertSelector(int $index, string $selector, array $style)
    {
        $this->insertSelector($index, $this->createSelector($selector, $style));

        return $this;
    }

    /**
     * @param string $selector
     * @param array $style
     * @return Selector
     * @throws \Exception
     */
    protected function createSelector(string $selector, array $style)
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(SelectorInterface::class, null, [$selector, $style]);
        } catch (\Exception $e) {
            $result = new Selector($selector, $style);
        }

        return $result;
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