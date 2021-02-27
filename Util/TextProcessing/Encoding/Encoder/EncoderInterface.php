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
namespace GI\Util\TextProcessing\Encoding\Encoder;

interface EncoderInterface
{
    const UTF_8_ENCODING      = 'UTF-8';

    const ENCODING_MULTI_BYTE = 'UTF-16BE';


    const CHECK_UTF8_REG_EXP = '/^./su';


    /**
     * @param string $char
     * @return bool
     */
    public function isCharNotInUTF8(string $char);

    /**
     * @param string $string
     * @return bool
     */
    public function isStringInUTF8(string $string);

    /**
     * @param string $string
     * @param string $to
     * @param array|string $from
     * @return string
     * @throws \Exception
     */
    public function convert(string $string, string $to, $from);

    /**
     * @param string $char
     * @return string
     * @throws \Exception
     */
    public function UTF8ToMultiByte(string $char);

    /**
     * @param string $string
     * @param string $encoding
     * @return string
     * @throws \Exception
     */
    public function toUTF8(string $string, string $encoding);

    /**
     * @param string $string
     * @param string $encoding
     * @return string
     * @throws \Exception
     */
    public function fromUTF8(string $string, string $encoding);
}