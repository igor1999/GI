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
namespace GI\Util\Crypt\Random\Word\Alphabet;

interface AlphabetInterface 
{
    /**
     * @return string[]
     */
    public function getCustom();

    /**
     * @param string[] $custom
     * @return static
     */
    public function setCustom(array $custom);

    /**
     * @return bool
     */
    public function isUpperCaseFlag();

    /**
     * @param bool $upperCaseFlag
     * @return static
     */
    public function setUpperCaseFlag(bool $upperCaseFlag);

    /**
     * @return bool
     */
    public function isLowerCaseFlag();

    /**
     * @param bool $lowerCaseFlag
     * @return static
     */
    public function setLowerCaseFlag(bool $lowerCaseFlag);

    /**
     * @return bool
     */
    public function isDigitsFlag();

    /**
     * @param bool $digitsFlag
     * @return static
     */
    public function setDigitsFlag(bool $digitsFlag);

    /**
     * @return bool
     */
    public function isSpecialCharsFlag();

    /**
     * @param bool $specialCharsFlag
     * @return static
     */
    public function setSpecialCharsFlag(bool $specialCharsFlag);

    /**
     * @return bool
     */
    public function isCustomFlag();

    /**
     * @param bool $customFlag
     * @return static
     */
    public function setCustomFlag(bool $customFlag);

    /**
     * @param bool $value
     * @return static
     */
    public function setAll(bool $value);

    /**
     * @return string[]
     */
    public function merge();
}