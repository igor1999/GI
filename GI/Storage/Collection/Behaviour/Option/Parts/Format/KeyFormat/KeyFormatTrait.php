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
namespace GI\Storage\Collection\Behaviour\Option\Parts\Format\KeyFormat;

trait KeyFormatTrait
{
    /**
     * @var string
     */
    private $keyFormat = '';


    /**
     * @return string
     */
    public function getKeyFormat()
    {
        return $this->keyFormat;
    }

    /**
     * @param string $keyFormat
     * @return static
     */
    protected function setKeyFormat(string $keyFormat)
    {
        $this->keyFormat = $keyFormat;

        return $this;
    }

    /**
     * @return static
     */
    public function setKeyFormatToCamelCaseUcFirst()
    {
        $this->setKeyFormat(self::KEY_FORMAT_CAMEL_CASE_UCFIRST);
        
        return $this;
    }

    /**
     * @return static
     */
    public function setKeyFormatToHyphenUpperCase()
    {
        $this->setKeyFormat(self::KEY_FORMAT_HYPHEN_UPPER_CASE);

        return $this;
    }

    /**
     * @return static
     */
    public function setKeyFormatToHyphenLowerCase()
    {
        $this->setKeyFormat(self::KEY_FORMAT_HYPHEN_LOWER_CASE);

        return $this;
    }

    /**
     * @return static
     */
    public function setKeyFormatToHyphenUcFirst()
    {
        $this->setKeyFormat(self::KEY_FORMAT_HYPHEN_UCFIRST);

        return $this;
    }

    /**
     * @return static
     */
    public function setKeyFormatToUnderlineUpperCase()
    {
        $this->setKeyFormat(self::KEY_FORMAT_UNDERLINE_UPPER_CASE);

        return $this;
    }

    /**
     * @return static
     */
    public function setKeyFormatToUnderlineLowerCase()
    {
        $this->setKeyFormat(self::KEY_FORMAT_UNDERLINE_LOWER_CASE);

        return $this;
    }

    /**
     * @return static
     */
    public function setKeyFormatToUnderlineUcFirst()
    {
        $this->setKeyFormat(self::KEY_FORMAT_UNDERLINE_UCFIRST);

        return $this;
    }
}