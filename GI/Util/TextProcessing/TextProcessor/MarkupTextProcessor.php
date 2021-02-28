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
namespace GI\Util\TextProcessing\TextProcessor;

use GI\Util\TextProcessing\Escaper\HTMLText\EscaperInterface;

class MarkupTextProcessor extends TextProcessor implements MarkupTextProcessorInterface
{
    /**
     * @var EscaperInterface
     */
    private $escaper;


    /**
     * MarkupTextProcessor constructor.
     */
    public function __construct()
    {
        $this->escaper = $this->giGetEscaperFactory()->createHTMLText();
    }

    /**
     * @return EscaperInterface
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @param string $string
     * @param int $length
     * @param string|null $charList
     * @return string
     */
    public function cutAndEscapeString(string $string, int $length, string $charList = null)
    {
        return $this->escaper->escape($this->cutString($string, $length, $charList));
    }

    /**
     * @param string $text
     * @param int $linesNumber
     * @return string
     */
    public function cutAndEscapeText(string $text, int $linesNumber = 0)
    {
        if (!empty($linesNumber)) {
            $text = $this->cutText($text, $linesNumber);
        }

        return $this->escaper->escape($text);
    }

    /**
     * @param string $text
     * @return string
     */
    public function nlToBrText(string $text)
    {
        return nl2br($text);
    }

    /**
     * @param string $text
     * @param int $linesNumber
     * @return string
     */
    public function prepareText(string $text, int $linesNumber = 0)
    {
        return $this->nlToBrText($this->cutAndEscapeText($text, $linesNumber));
    }
}