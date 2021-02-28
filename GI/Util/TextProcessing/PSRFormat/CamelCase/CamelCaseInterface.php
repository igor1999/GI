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
namespace GI\Util\TextProcessing\PSRFormat\CamelCase;

interface CamelCaseInterface
{
    const SEPARATOR_HYPHEN    = '-';

    const SEPARATOR_UNDERLINE = '_';


    const MODE_UPPER_CASE  = 'upper_case';

    const MODE_LOWER_CASE  = 'lower_case';

    const MODE_UPPER_FIRST = 'upper_first';


    /**
     * @param string $source
     * @param string $separator
     * @param string $mode
     * @return string
     * @throws \Exception
     */
    public function convertToSeparated(string $source, string $separator, string $mode = self::MODE_LOWER_CASE);

    /**
     * @param string $source
     * @param string $separator
     * @param bool $lcFirst
     * @return string
     */
    public function convertToCamelCase(string $source, string $separator, bool $lcFirst = true);

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToHyphenUpperCase(string $source);

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToHyphenLowerCase(string $source);

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToHyphenUpperFirst(string $source);

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToUnderlineUpperCase(string $source);

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToUnderlineLowerCase(string $source);

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToUnderlineUpperFirst(string $source);

    /**
     * @param string $source
     * @return string
     */
    public function convertHyphenToCamelCaseUpperFirst(string $source);

    /**
     * @param string $source
     * @return string
     */
    public function convertHyphenToCamelCaseLowerFirst(string $source);

    /**
     * @param string $source
     * @return string
     */
    public function convertUnderlineToCamelCaseUpperFirst(string $source);

    /**
     * @param string $source
     * @return string
     */
    public function convertUnderlineToCamelCaseLowerFirst(string $source);
}