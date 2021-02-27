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

use GI\DOM\HTML\Element\ContainerElement;

class Option extends ContainerElement implements OptionInterface
{
    const TAG = 'option';


    /**
     * Option constructor.
     * @param string|int $value
     * @param string $text
     * @param bool $selected
     * @throws \Exception
     */
    public function __construct($value = '', string $text = '', bool $selected = false)
    {
        parent::__construct(static::TAG);

        $this->setValue($value)->setSelected($selected)->getChildNodes()->set($text);
    }

    /**
     * @return string
     */
    protected function compileInnerHTML()
    {
        return strip_tags(parent::compileInnerHTML());
    }

    /**
     * @param string|int $value
     * @return static
     */
    public function setValue($value)
    {
        $this->getAttributes()->setValue($value);

        return $this;
    }

    /**
     * @param bool $selected
     * @return static
     */
    public function setSelected(bool $selected)
    {
        $this->getAttributes()->setSelected((bool)$selected);

        return $this;
    }
}