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
namespace GI\Component\Autocomplete\View;

use GI\Component\Autocomplete\Context\ContextInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Input\Text\TextInterface;
use GI\DOM\HTML\Element\Lists\UL\ULInterface;
use GI\Component\Base\View\Widget\WidgetInterface as BaseInterface;

interface WidgetInterface extends BaseInterface
{
    /**
     * @return ResourceRendererInterface
     */
    public function getResourceRenderer();

    /**
     * @return array
     */
    public function getName();

    /**
     * @param array $name
     * @return static
     */
    public function setName(array $name);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value);

    /**
     * @param ContextInterface $contents
     * @return static
     */
    public function setContext(ContextInterface $contents);

    /**
     * @return TextInterface
     */
    public function getTextbox();

    /**
     * @return DivInterface
     */
    public function getListContainer();

    /**
     * @return ULInterface
     */
    public function getList();
}