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

use GI\DOM\HTML\Attributes\Style\Style;

/**
 * Class Selector
 * @package  GI\DOM\HTML\Element\Style\Selector
 *
 * @method string getLeft()
 * @method SelectorInterface setLeft(string $value)
 * @method string getTop()
 * @method SelectorInterface setTop(string $value)
 * @method string getHeight()
 * @method SelectorInterface setHeight(string $value)
 * @method string getWidth()
 * @method SelectorInterface setWidth(string $value)
 * @method string getMinHeight()
 * @method SelectorInterface setMinHeight(string $value)
 * @method string getMinWidth()
 * @method SelectorInterface setMinWidth(string $value)
 *
 * @method bool isPositionEqualRelative()
 * @method SelectorInterface setPositionToRelative()
 * @method bool isPositionEqualAbsolute()
 * @method SelectorInterface setPositionToAbsolute()
 * @method bool isPositionEqualFixed()
 * @method SelectorInterface setPositionToFixed()
 *
 * @method string getBackground()
 * @method SelectorInterface setBackground(string $value)
 * @method string getBackgroundColor()
 * @method SelectorInterface setBackgroundColor(string $value)
 * @method string getBackgroundImage()
 * @method SelectorInterface setBackgroundImage(string $value)
 *
 * @method string getBorder()
 * @method SelectorInterface setBorder(string $value)
 * @method string getBorderLeft()
 * @method SelectorInterface setBorderLeft(string $value)
 * @method string getBorderTop()
 * @method SelectorInterface setBorderTop(string $value)
 * @method string getBorderRight()
 * @method SelectorInterface setBorderRight(string $value)
 * @method string getBorderBottom()
 * @method SelectorInterface setBorderBottom(string $value)
 *
 * @method string getMargin()
 * @method SelectorInterface setMargin(string $value)
 * @method string getMarginLeft()
 * @method SelectorInterface setMarginLeft(string $value)
 * @method string getMarginTop()
 * @method SelectorInterface setMarginTop(string $value)
 * @method string getMarginRight()
 * @method SelectorInterface setMarginRight(string $value)
 * @method string getMarginBottom()
 * @method SelectorInterface setMarginBottom(string $value)
 *
 * @method string getPadding()
 * @method SelectorInterface setPadding(string $value)
 * @method string getPaddingLeft()
 * @method SelectorInterface setPaddingLeft(string $value)
 * @method string getPaddingTop()
 * @method SelectorInterface setPaddingTop(string $value)
 * @method string getPaddingRight()
 * @method SelectorInterface setPaddingRight(string $value)
 * @method string getPaddingBottom()
 * @method SelectorInterface setPaddingBottom(string $value)
 *
 * @method bool isVisibilityEqualHidden()
 * @method SelectorInterface setVisibilityToHidden()
 * @method bool isVisibilityEqualInherit()
 * @method SelectorInterface setVisibilityToInherit()
 * @method bool isVisibilityEqualVisible()
 * @method SelectorInterface setVisibilityToVisible()
 *
 * @method bool isDisplayEqualNone()
 * @method SelectorInterface setDisplayToNone()
 * @method bool isDisplayEqualBlock()
 * @method SelectorInterface setDisplayToBlock()
 * @method bool isDisplayEqualInline()
 * @method SelectorInterface setDisplayToInline()
 * @method bool isDisplayEqualInlineBlock()
 * @method SelectorInterface setDisplayToInlineBlock()
 * @method bool isDisplayEqualTable()
 * @method SelectorInterface setDisplayToTable()
 * @method bool isDisplayEqualTableCell()
 * @method SelectorInterface setDisplayToTableCell()
 * @method bool isDisplayEqualTableRow()
 * @method SelectorInterface setDisplayToTableRow()
 * @method bool isDisplayEqualInherit()
 * @method SelectorInterface setDisplayToInherit()
 *
 * @method bool isFloatEqualLeft()
 * @method SelectorInterface setFloatToLeft()
 * @method bool isFloatEqualRight()
 * @method SelectorInterface setFloatToRight()
 * @method bool isFloatEqualNone()
 * @method SelectorInterface setFloatToNone()
 *
 * @method bool isClearEqualLeft()
 * @method SelectorInterface setClearToLeft()
 * @method bool isClearEqualRight()
 * @method SelectorInterface setClearToRight()
 * @method bool isClearEqualBoth()
 * @method SelectorInterface setClearToBoth()
 *
 * @method SelectorInterface setCursor(string $cursor)
 * @method SelectorInterface setCursorToAuto()
 * @method SelectorInterface setCursorToDefault()
 * @method SelectorInterface setCursorToHelp()
 * @method SelectorInterface setCursorToMove()
 * @method SelectorInterface setCursorToPointer()
 */
class Selector extends Style implements SelectorInterface
{
    /**
     * @var string
     */
    private $selector = '';


    /**
     * Selector constructor.
     * @param string $selector
     * @param array $attributes
     * @throws \Exception
     */
    public function __construct(string $selector, array $attributes = [])
    {
        $this->selector = $selector;

        parent::__construct();

        foreach ($attributes  as $attribute => $value) {
            $this->set($attribute, $value);
        }
    }

    /**
     * @return string
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * @param string $selector
     * @return static
     */
    public function setSelector(string $selector)
    {
        $this->selector = $selector;

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->selector . '{' . PHP_EOL . $this->renderStyleValue() . PHP_EOL . '}' . PHP_EOL;
    }
}