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

use GI\Util\Crypt\Random\Constants\Alphabets;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\Crypt\Random\Word\Alphabet\Context\ContextInterface;

class Alphabet implements AlphabetInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string[]
     */
    private $custom = [];

    /**
     * @var bool
     */
    private $upperCaseFlag = true;

    /**
     * @var bool
     */
    private $lowerCaseFlag = true;

    /**
     * @var bool
     */
    private $digitsFlag = true;

    /**
     * @var bool
     */
    private $specialCharsFlag = true;

    /**
     * @var bool
     */
    private $customFlag = true;


    /**
     * Alphabet constructor.
     */
    public function __construct()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);
            $this->custom = $context->getCustom();
        } catch (\Exception $e) {}
    }

    /**
     * @return string[]
     */
    public function getUpperCase()
    {
        return Alphabets::UPPER_CASE_LETTERS;
    }

    /**
     * @return string[]
     */
    public function getLowerCase()
    {
        return Alphabets::LOWER_CASE_LETTERS;
    }

    /**
     * @return string[]
     */
    public function getDigits()
    {
        return Alphabets::DIGITS;
    }

    /**
     * @return string[]
     */
    public function getSpecialChars()
    {
        return Alphabets::SPECIAL_CHARS;
    }

    /**
     * @return string[]
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * @param string[] $custom
     * @return static
     */
    public function setCustom(array $custom)
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUpperCaseFlag()
    {
        return $this->upperCaseFlag;
    }

    /**
     * @param bool $upperCaseFlag
     * @return static
     */
    public function setUpperCaseFlag(bool $upperCaseFlag)
    {
        $this->upperCaseFlag = $upperCaseFlag;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLowerCaseFlag()
    {
        return $this->lowerCaseFlag;
    }

    /**
     * @param bool $lowerCaseFlag
     * @return static
     */
    public function setLowerCaseFlag(bool $lowerCaseFlag)
    {
        $this->lowerCaseFlag = $lowerCaseFlag;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDigitsFlag()
    {
        return $this->digitsFlag;
    }

    /**
     * @param bool $digitsFlag
     * @return static
     */
    public function setDigitsFlag(bool $digitsFlag)
    {
        $this->digitsFlag = $digitsFlag;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSpecialCharsFlag()
    {
        return $this->specialCharsFlag;
    }

    /**
     * @param bool $specialCharsFlag
     * @return static
     */
    public function setSpecialCharsFlag(bool $specialCharsFlag)
    {
        $this->specialCharsFlag = $specialCharsFlag;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCustomFlag()
    {
        return $this->customFlag;
    }

    /**
     * @param bool $customFlag
     * @return static
     */
    public function setCustomFlag(bool $customFlag)
    {
        $this->customFlag = $customFlag;

        return $this;
    }

    /**
     * @param bool $value
     * @return static
     */
    public function setAll(bool $value)
    {
        $this->setUpperCaseFlag($value)
            ->setLowerCaseFlag($value)
            ->setDigitsFlag($value)
            ->setSpecialCharsFlag($value)
            ->setCustomFlag($value);

        return $this;
    }

    /**
     * @return string[]
     */
    public function merge()
    {
        $result = [];

        if ($this->isUpperCaseFlag()) {
            $result = array_merge($result, $this->getUpperCase());
        }

        if ($this->isLowerCaseFlag()) {
            $result = array_merge($result, $this->getLowerCase());
        }

        if ($this->isDigitsFlag()) {
            $result = array_merge($result, $this->getDigits());
        }

        if ($this->isSpecialCharsFlag()) {
            $result = array_merge($result, $this->getSpecialChars());
        }

        if ($this->isCustomFlag()) {
            $result = array_merge($result, $this->getCustom());
        }

        return $result;
    }
}