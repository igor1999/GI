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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class TextProcessor implements TextProcessorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @param string $string
     * @param int $length
     * @param string|null $charList
     * @return string
     */
    public function cutString(string $string, int $length, string $charList = null)
    {
        if (empty($string)) {
            $result = '';
        } else {
            $words = str_word_count($string, 2, $charList);

            $maxPosition = 0;

            foreach ($words as $position => $word) {
                if ($position >= $length) {
                    $maxPosition = $position;
                    break;
                }
            }

            if ($maxPosition == 0) {
                $result = $string;
            } else {
                $result = substr($string, 0, $maxPosition);
                $result = rtrim(trim($result), ',.:;') . '...';
            }
        }

        return $result;
    }

    /**
     * @param string $text
     * @param int $linesNumber
     * @return string
     */
    public function cutText(string $text, int $linesNumber)
    {
        if (!empty($text)) {
            $text = explode(PHP_EOL,  $text);

            if (count($text) <= $linesNumber) {
                $text = implode(PHP_EOL, $text);
            } else {
                $text = array_slice($text, 0 , $linesNumber);
                $text = implode(PHP_EOL, $text);
                $text = rtrim(trim($text), '.,:;') . '...';
            }
        }

        return $text;
    }
}