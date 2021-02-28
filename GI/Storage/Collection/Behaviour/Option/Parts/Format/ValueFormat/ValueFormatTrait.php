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
namespace GI\Storage\Collection\Behaviour\Option\Parts\Format\ValueFormat;

trait ValueFormatTrait
{
    /**
     * @var string
     */
    private $valueFormat = '';


    /**
     * @return string
     */
    public function getValueFormat()
    {
        return $this->valueFormat;
    }

    /**
     * @param string $valueFormat
     * @return static
     */
    protected function setValueFormat(string $valueFormat)
    {
        $this->valueFormat = $valueFormat;

        return $this;
    }

    /**
     * @return static
     */
    public function setValueFormatToCamelCaseUcFirst()
    {
        $this->setValueFormat(self::VALUE_FORMAT_CAMEL_CASE_UCFIRST);
        
        return $this;
    }

    /**
     * @return static
     */
    public function setValueFormatToHyphenUpperCase()
    {
        $this->setValueFormat(self::VALUE_FORMAT_HYPHEN_UPPER_CASE);

        return $this;
    }

    /**
     * @return static
     */
    public function setValueFormatToHyphenLowerCase()
    {
        $this->setValueFormat(self::VALUE_FORMAT_HYPHEN_LOWER_CASE);

        return $this;
    }

    /**
     * @return static
     */
    public function setValueFormatToHyphenUcFirst()
    {
        $this->setValueFormat(self::VALUE_FORMAT_HYPHEN_UCFIRST);

        return $this;
    }

    /**
     * @return static
     */
    public function setValueFormatToUnderlineUpperCase()
    {
        $this->setValueFormat(self::VALUE_FORMAT_UNDERLINE_UPPER_CASE);

        return $this;
    }

    /**
     * @return static
     */
    public function setValueFormatToUnderlineLowerCase()
    {
        $this->setValueFormat(self::VALUE_FORMAT_UNDERLINE_LOWER_CASE);

        return $this;
    }

    /**
     * @return static
     */
    public function setValueFormatToUnderlineUcFirst()
    {
        $this->setValueFormat(self::VALUE_FORMAT_UNDERLINE_UCFIRST);

        return $this;
    }
}