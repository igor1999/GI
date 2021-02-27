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
namespace GI\DOM\HTML\Element\Select\Items;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\HTML\Element\Select\Optgroup\OptgroupInterface;
use GI\DOM\HTML\Element\Select\Option\OptionInterface;
use GI\DOM\Base\NodeInterface;

interface ItemsInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return ItemInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return ItemInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return ItemInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return OptionInterface[]
     */
    public function getOptions();

    /**
     * @return ItemInterface[]
     */
    public function getItems();

    /**
     * @param OptgroupInterface|null $optgroup
     * @return static
     */
    public function addOptgroup(OptgroupInterface $optgroup = null);

    /**
     * @param string $label
     * @return static
     */
    public function createAndAddOptgroup(string $label = '');

    /**
     * @param int $index
     * @param OptgroupInterface|null $optgroup
     * @return static
     */
    public function insertOptgroup(int $index, OptgroupInterface $optgroup = null);

    /**
     * @param OptionInterface|null $option
     * @return static
     */
    public function addOption(OptionInterface $option = null);

    /**
     * @param string $value
     * @param string $text
     * @param bool $selected
     * @return static
     */
    public function createAndAddOption(string $value = '', string $text = '', bool $selected = false);

    /**
     * @param int $index
     * @param OptionInterface|null  $option
     * @return static
     */
    public function insertOption(int $index, OptionInterface $option = null);

    /**
     * @param int $index
     * @param string $value
     * @param string $text
     * @param bool $selected
     * @return static
     */
    public function createAndInsertOption(int $index, string $value = '', string $text = '', bool $selected = false);

    /**
     * @param int $index
     * @param string $label
     * @return static
     */
    public function createInsertAddOptgroup(int $index, string $label = '');

    /**
     * @return static
     */
    public function clean();
}