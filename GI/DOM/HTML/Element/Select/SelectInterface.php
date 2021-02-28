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
namespace GI\DOM\HTML\Element\Select;

use GI\DOM\HTML\Element\ContainerElementInterface;
use GI\ClientContents\Selection\ImmutableInterface as SelectionInterface;
use GI\DOM\HTML\Element\Select\Items\ItemsInterface;

interface SelectInterface extends ContainerElementInterface
{
    /**
     * @return ItemsInterface
     */
    public function getChildNodes();

    /**
     * @param int $size
     * @return static
     */
    public function setSize(int $size);

    /**
     * @param bool $multiple
     * @return static
     */
    public function setMultiple(bool $multiple);

    /**
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(bool $disabled);

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function getValue();

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value);

    /**
     * @param array $contents
     * @return static
     */
    public function build(array $contents);

    /**
     * @param int $first
     * @param int $last
     * @param int $step
     * @param \Closure|null $textProcessor
     * @return static
     * @throws \Exception
     */
    public function buildSequence(int $first, int $last, int $step = 1, \Closure $textProcessor = null);

    /**
     * @param array $values
     * @param \Closure|null $textProcessor
     * @return static
     */
    public function buildByValues(array $values, \Closure $textProcessor = null);

    /**
     * @param SelectionInterface $selection
     * @return static
     */
    public function buildBySelection(SelectionInterface $selection);
}