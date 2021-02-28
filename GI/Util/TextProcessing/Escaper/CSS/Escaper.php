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
namespace GI\Util\TextProcessing\Escaper\CSS;

use GI\Util\TextProcessing\Escaper\AbstractAttributeEscaper;

class Escaper extends AbstractAttributeEscaper implements EscaperInterface
{
    const FORMAT_CHAR_BITE = '\\%X ';


    /**
     * @param string $char
     * @return string
     * @throws \Exception
     */
    protected function escapeChar(string $char)
    {
        $encoder = $this->giGetEncoder();

        if (strlen($char) == 1) {
            $ord = ord($char);
        } else {
            $char = $encoder->UTF8ToMultiByte($char);
            $ord  = hexdec(bin2hex($char));
        }

        return sprintf(static::FORMAT_CHAR_BITE, $ord);
    }

    /**
     * @return string
     */
    protected function getMatchAttributeRegExp()
    {
        return '/[^a-z0-9]/iSu';
    }
}