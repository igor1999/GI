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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class CamelCase implements CamelCaseInterface
{
    use ServiceLocatorAwareTrait;
    

    /**
     * @param string $source
     * @param string $separator
     * @param string $mode
     * @return string
     * @throws \Exception
     */
    public function convertToSeparated(string $source, string $separator, string $mode = self::MODE_LOWER_CASE)
    {
        $words = preg_replace('/[A-Z]/', ' ' . '$0', $source);

        switch ($mode) {
            case self::MODE_UPPER_CASE:
                $words = strtoupper($words);
                break;
            case self::MODE_LOWER_CASE:
                $words = strtolower($words);
                break;
            case self::MODE_UPPER_FIRST:
                $words = ucwords($words);
                break;
            default:
                $this->giThrowNotFoundException('Conversion mode');
       }

        $words = explode(' ', trim($words));

        return implode($separator, $words);
    }

    /**
     * @param string $source
     * @param string $separator
     * @param bool $lcFirst
     * @return string
     */
    public function convertToCamelCase(string $source, string $separator, bool $lcFirst = true)
    {
        $words = explode($separator, $source);
        $words = implode(' ', $words);
        $words = strtolower($words);
        $words = ucwords($words);
        $words = explode(' ', $words);
        $words = implode('', $words);

        return $lcFirst ? lcfirst($words): ucfirst($words);
    }

    /**
     * @param string $source
     * @return string
     * @throws \Exception
    */
    public function convertToHyphenUpperCase(string $source)
    {
        return $this->convertToSeparated($source, self::SEPARATOR_HYPHEN, self::MODE_UPPER_CASE);
    }

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToHyphenLowerCase(string $source)
    {
        return $this->convertToSeparated($source, self::SEPARATOR_HYPHEN, self::MODE_LOWER_CASE);
    }

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToHyphenUpperFirst(string $source)
    {
        return $this->convertToSeparated($source, self::SEPARATOR_HYPHEN, self::MODE_UPPER_FIRST);
    }

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToUnderlineUpperCase(string $source)
    {
        return $this->convertToSeparated($source, self::SEPARATOR_UNDERLINE, self::MODE_UPPER_CASE);
    }

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToUnderlineLowerCase(string $source)
    {
        return $this->convertToSeparated($source, self::SEPARATOR_UNDERLINE, self::MODE_LOWER_CASE);
    }

    /**
     * @param string $source
     * @return string
     * @throws \Exception
     */
    public function convertToUnderlineUpperFirst(string $source)
    {
        return $this->convertToSeparated($source, self::SEPARATOR_UNDERLINE, self::MODE_UPPER_FIRST);
    }

    /**
     * @param string $source
     * @return string
     */
    public function convertHyphenToCamelCaseUpperFirst(string $source)
    {
        return $this->convertToCamelCase($source, self::SEPARATOR_HYPHEN, false);
    }

    /**
     * @param string $source
     * @return string
     */
    public function convertHyphenToCamelCaseLowerFirst(string $source)
    {
        return $this->convertToCamelCase($source, self::SEPARATOR_HYPHEN, true);
    }

    /**
     * @param string $source
     * @return string
     */
    public function convertUnderlineToCamelCaseUpperFirst(string $source)
    {
        return $this->convertToCamelCase($source, self::SEPARATOR_UNDERLINE, false);
    }

    /**
     * @param string $source
     * @return string
     */
    public function convertUnderlineToCamelCaseLowerFirst(string $source)
    {
        return $this->convertToCamelCase($source, self::SEPARATOR_UNDERLINE, true);
    }
}