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
namespace GI\Util\TextProcessing\Escaper\HTMLAttribute;

use GI\Util\TextProcessing\Escaper\AbstractAttributeEscaper;

class Escaper extends AbstractAttributeEscaper implements EscaperInterface
{
    const UTF8_ERROR_CHAR = '&#xFFFD;';


    const FORMAT_MULTI_BITE  = '&#x%04X;';

    const FORMAT_SINGLE_BITE = '&#x%02X;';


    /**
     * @return array
     */
    protected function getNamedEntities()
    {
        return [
            34 => 'quot',
            38 => 'amp',
            60 => 'lt',
            62 => 'gt',
        ];
    }

    /**
     * @param string $char
     * @return string
     * @throws \Exception
     */
    protected function escapeChar(string $char)
    {
        $encoder = $this->giGetEncoder();

        if ($encoder->isCharNotInUTF8($char)) {
            $result = static::UTF8_ERROR_CHAR;
        } else {
            if (strlen($char) > 1) {
                $char = $encoder->UTF8ToMultiByte($char);
            }

            $ord = hexdec(bin2hex($char));

            if (isset($this->getNamedEntities()[$ord])) {
                $result = '&' . $this->getNamedEntities()[$ord] . ';';
            } elseif ($ord > 255) {
                $result = sprintf(static::FORMAT_MULTI_BITE, $ord);
            } else {
                $result = sprintf(static::FORMAT_SINGLE_BITE, $ord);
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function getMatchAttributeRegExp()
    {
        return '/[^a-z0-9,\.\-_]/iSu';
    }
}