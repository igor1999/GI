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
namespace GI\Util\TextProcessing\Escaper\JS;

use GI\Util\TextProcessing\Escaper\AbstractAttributeEscaper;

class Escaper extends AbstractAttributeEscaper implements EscaperInterface
{
    const FORMAT_CHAR_MULTI_BITE  = '\\u%04s';

    const FORMAT_CHAR_SINGLE_BITE = '\\x%02X';


    /**
     * @param string $char
     * @return string
     * @throws \Exception
     */
    protected function escapeChar(string $char)
    {
        $encoder = $this->getGiServiceLocator()->getUtilites()->getEncoder();

        if (strlen($char) == 1) {
            $result = sprintf(static::FORMAT_CHAR_SINGLE_BITE, ord($char));
        } else {
            $char   = $encoder->UTF8ToMultiByte($char);
            $result = sprintf(static::FORMAT_CHAR_MULTI_BITE, strtoupper(bin2hex($char)));
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function getMatchAttributeRegExp()
    {
        return '/[^a-z0-9,\._]/iSu';
    }
}