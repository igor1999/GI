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

interface MarkupTextProcessorInterface extends TextProcessorInterface
{
    /**
     * @return EscaperInterface
     */
    public function getEscaper();

    /**
     * @param string $string
     * @param int $length
     * @param string|null $charList
     * @return string
     */
    public function cutAndEscapeString(string $string, int $length, string $charList = null);

    /**
     * @param string $text
     * @param int $linesNumber
     * @return string
     */
    public function cutAndEscapeText(string $text, int $linesNumber = 0);

    /**
     * @param string $text
     * @return string
     */
    public function nlToBrText(string $text);

    /**
     * @param string $text
     * @param int $linesNumber
     * @return string
     */
    public function prepareText(string $text, int $linesNumber = 0);
}