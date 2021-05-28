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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Encoder implements EncoderInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @param string $char
     * @return bool
     */
    public function isCharNotInUTF8(string $char)
    {
        $ord = ord($char);

        $notFound = $ord <= 0x1f;
        $notFound = $notFound && !in_array($char, ["\t", "\n", "\r"]);
        $notFound = $notFound || ($ord >= 0x7f && $ord <= 0x9f);

        return $notFound;
    }

    /**
     * @param string $string
     * @return bool
     */
    public function isStringInUTF8(string $string)
    {
        return ($string === '') || preg_match(self::CHECK_UTF8_REG_EXP, $string);
    }

    /**
     * @param string $string
     * @param string $to
     * @param array|string $from
     * @return string
     * @throws \Exception
     */
    public function convert(string $string, string $to, $from)
    {
        if (function_exists('iconv')) {
            $result = iconv($from, $to, $string);
        } elseif (function_exists('mb_convert_encoding')) {
            $result = mb_convert_encoding($string, $to, $from);
        } else {
            $result = null;
            $this->getGiServiceLocator()->throwNotFoundException('iconv/mb_convert_encoding');
        }

        return $result;
    }

    /**
     * @param string $char
     * @return string
     * @throws \Exception
     */
    public function UTF8ToMultiByte(string $char)
    {
        return $this->convert($char, self::ENCODING_MULTI_BYTE, self::UTF_8_ENCODING);
    }

    /**
     * @param string $string
     * @param string $encoding
     * @return string
     * @throws \Exception
     */
    public function toUTF8(string $string, string $encoding)
    {
        if (strtoupper($encoding) !== self::UTF_8_ENCODING) {
            $string = $this->convert($string, self::UTF_8_ENCODING, $encoding);
        }

        if (!$this->isStringInUTF8($string)) {
            $this->getGiServiceLocator()->throwCommonException('Converted string \'%s\' is not valid UTF-8', [$string]);
        }

        return $string;
    }

    /**
     * @param string $string
     * @param string $encoding
     * @return string
     * @throws \Exception
     */
    public function fromUTF8(string $string, string $encoding)
    {
        if (!$this->isStringInUTF8($string)) {
            $this->getGiServiceLocator()->throwCommonException('Converted string \'%s\' is not valid UTF-8', [$string]);
        }

        if (strtoupper($encoding) !== self::UTF_8_ENCODING) {
            $string = $this->convert($string, $encoding, self::UTF_8_ENCODING);
        }

        return $string;
    }
}

