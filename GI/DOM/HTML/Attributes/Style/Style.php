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
namespace GI\DOM\HTML\Attributes\Style;

use GI\DOM\Base\Attributes\AbstractAttributes;

use GI\Util\TextProcessing\Escaper\CSS\EscaperInterface;

/**
 * Class Style
 * @package GI\DOM\HTML\Attributes\Style

 * @method string getLeft()
 * @method StyleInterface setLeft(string $value)
 * @method string getTop()
 * @method StyleInterface setTop(string $value)
 * @method string getHeight()
 * @method StyleInterface setHeight(string $value)
 * @method string getWidth()
 * @method StyleInterface setWidth(string $value)
 * @method string getMinHeight()
 * @method StyleInterface setMinHeight(string $value)
 * @method string getMinWidth()
 * @method StyleInterface setMinWidth(string $value)
 *
 * @method bool isPositionEqualRelative()
 * @method StyleInterface setPositionToRelative()
 * @method bool isPositionEqualAbsolute()
 * @method StyleInterface setPositionToAbsolute()
 * @method bool isPositionEqualFixed()
 * @method StyleInterface setPositionToFixed()
 *
 * @method string getBackground()
 * @method StyleInterface setBackground(string $value)
 * @method string getBackgroundColor()
 * @method StyleInterface setBackgroundColor(string $value)
 * @method string getBackgroundImage()
 * @method StyleInterface setBackgroundImage(string $value)
 *
 * @method string getBorder()
 * @method StyleInterface setBorder(string $value)
 * @method string getBorderLeft()
 * @method StyleInterface setBorderLeft(string $value)
 * @method string getBorderTop()
 * @method StyleInterface setBorderTop(string $value)
 * @method string getBorderRight()
 * @method StyleInterface setBorderRight(string $value)
 * @method string getBorderBottom()
 * @method StyleInterface setBorderBottom(string $value)
 *
 * @method string getMargin()
 * @method StyleInterface setMargin(string $value)
 * @method string getMarginLeft()
 * @method StyleInterface setMarginLeft(string $value)
 * @method string getMarginTop()
 * @method StyleInterface setMarginTop(string $value)
 * @method string getMarginRight()
 * @method StyleInterface setMarginRight(string $value)
 * @method string getMarginBottom()
 * @method StyleInterface setMarginBottom(string $value)
 *
 * @method string getPadding()
 * @method StyleInterface setPadding(string $value)
 * @method string getPaddingLeft()
 * @method StyleInterface setPaddingLeft(string $value)
 * @method string getPaddingTop()
 * @method StyleInterface setPaddingTop(string $value)
 * @method string getPaddingRight()
 * @method StyleInterface setPaddingRight(string $value)
 * @method string getPaddingBottom()
 * @method StyleInterface setPaddingBottom(string $value)
 *
 * @method bool isVisibilityEqualHidden()
 * @method StyleInterface setVisibilityToHidden()
 * @method bool isVisibilityEqualInherit()
 * @method StyleInterface setVisibilityToInherit()
 * @method bool isVisibilityEqualVisible()
 * @method StyleInterface setVisibilityToVisible()
 *
 * @method bool isDisplayEqualNone()
 * @method StyleInterface setDisplayToNone()
 * @method bool isDisplayEqualBlock()
 * @method StyleInterface setDisplayToBlock()
 * @method bool isDisplayEqualInline()
 * @method StyleInterface setDisplayToInline()
 * @method bool isDisplayEqualInlineBlock()
 * @method StyleInterface setDisplayToInlineBlock()
 * @method bool isDisplayEqualTable()
 * @method StyleInterface setDisplayToTable()
 * @method bool isDisplayEqualTableCell()
 * @method StyleInterface setDisplayToTableCell()
 * @method bool isDisplayEqualTableRow()
 * @method StyleInterface setDisplayToTableRow()
 * @method bool isDisplayEqualInherit()
 * @method StyleInterface setDisplayToInherit()
 *
 * @method bool isFloatEqualLeft()
 * @method StyleInterface setFloatToLeft()
 * @method bool isFloatEqualRight()
 * @method StyleInterface setFloatToRight()
 * @method bool isFloatEqualNone()
 * @method StyleInterface setFloatToNone()
 *
 * @method bool isClearEqualLeft()
 * @method StyleInterface setClearToLeft()
 * @method bool isClearEqualRight()
 * @method StyleInterface setClearToRight()
 * @method bool isClearEqualBoth()
 * @method StyleInterface setClearToBoth()
 *
 * @method StyleInterface setCursor(string $cursor)
 * @method StyleInterface setCursorToAuto()
 * @method StyleInterface setCursorToDefault()
 * @method StyleInterface setCursorToHelp()
 * @method StyleInterface setCursorToMove()
 * @method StyleInterface setCursorToPointer()
 */
class Style extends AbstractAttributes implements StyleInterface
{
    const ATTRIBUTE_RENDERING_PATTERN = '%s: %s;';


    /**
     * @var EscaperInterface
     */
    private $escaper;


    /**
     * @return static
     */
    protected function createEscaper()
    {
        $this->escaper = $this->giGetUtilites()->getEscaperFactory()->createCSS();

        return $this;
    }

    /**
     * @return EscaperInterface
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @param string $url
     * @return static
     */
    public function setBackgroundImageToUrl(string $url)
    {
        $this->setBackgroundImage('url(\'' . $url . '\')');

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $output = $this->renderStyleValue();

        if (!empty($output)) {
            $output = 'style="' . $output . '"';
        }

        return $output;
    }

    /**
     * @return string
     */
    public function renderStyleValue()
    {
        $output = [];

        foreach ($this->getItemsWithConstantAttributes() as $key => $value) {
            $value = $this->escapeAttribute($key, $value);
            $output[] = sprintf(static::ATTRIBUTE_RENDERING_PATTERN, $key, $value);
        }

        return !empty($output) ? implode(' ', $output) : '';
    }
}