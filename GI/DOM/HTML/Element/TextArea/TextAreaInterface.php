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
namespace GI\DOM\HTML\Element\TextArea;

use GI\DOM\HTML\Element\ContainerElementInterface;
use GI\DOM\HTML\Element\Extras\TextBox\TextBoxInterface;
use GI\DOM\HTML\Element\TextArea\Nodes\NodesListInterface;

interface TextAreaInterface extends ContainerElementInterface, TextBoxInterface
{
    /**
     * @return NodesListInterface
     */
    public function getChildNodes();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value);

    /**
     * @param int $number
     * @return static
     */
    public function setRows(int $number);

    /**
     * @param int $number
     * @return static
     */
    public function setCols(int $number);
}