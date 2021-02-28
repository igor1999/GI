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
namespace GI\DOM\HTML\Element\Select\Option;

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;

use GI\DOM\Base\NodeInterface;

class OptionList extends AbstractImmutable implements OptionListInterface
{
    /**
     * @param int $index
     * @return OptionInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var OptionInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return OptionInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var OptionInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return OptionInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var OptionInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return OptionInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var OptionInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return OptionInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var OptionInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return OptionInterface[]
     */
    public function getItems()
    {
        /** @var OptionInterface[] $children */
        $children = parent::getItems();

        return $children;
    }

    /**
     * @param OptionInterface|null $option
     * @return static
     */
    public function addOption(OptionInterface $option = null)
    {
        $option = ($option instanceof OptionInterface) ? $option : $this->createOption();

        $this->add($option);

        return $this;
    }

    /**
     * @param string $value
     * @param string $text
     * @param bool $selected
     * @return static
     */
    public function createAndAddOption(string $value = '', string $text = '', bool $selected = false)
    {
        $this->addOption($this->createOption($value, $text, $selected));

        return $this;
    }

    /**
     * @param int $index
     * @param OptionInterface|null  $option
     * @return static
     */
    public function insertOption(int $index, OptionInterface $option = null)
    {
        $option = ($option instanceof OptionInterface) ? $option : $this->createOption();

        $this->insert($index, $option);

        return $this;
    }

    /**
     * @param int $index
     * @param string $value
     * @param string $text
     * @param bool $selected
     * @return static
     */
    public function createAndInsertOption(int $index, string $value = '', string $text = '', bool $selected = false)
    {
        $this->insertOption($index, $this->createOption($value, $text, $selected));

        return $this;
    }

    /**
     * @param string $value
     * @param string $text
     * @param bool $selected
     * @return OptionInterface
     */
    protected function createOption(string $value = '', string $text = '', bool $selected = false)
    {
        return $this->giGetDOMFactory()->createOption($value, $text, $selected);
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