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
namespace GI\CLI\CommandLine\Argument;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Closing\ClosingTrait;

class Argument implements ArgumentInterface
{
    use ServiceLocatorAwareTrait, ClosingTrait;


    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $value = '';

    /**
     * @var bool
     */
    private $base64 = false;


    /**
     * Argument constructor.
     * @param string $raw
     * @throws \Exception
     * @throws \Exception
     */
    public function __construct(string $raw = '')
    {
        $this->read($raw);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return static
     * @throws \Exception
     */
    public function setName(string $name)
    {
        $this->validateClosing();

        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return static
     * @throws \Exception
     */
    public function setValue(string $value)
    {
        $this->validateClosing();

        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNamed()
    {
        return !empty($this->name);
    }

    /**
     * @return bool
     */
    public function isBase64()
    {
        return $this->base64;
    }

    /**
     * @param bool $base64
     * @return static
     */
    public function setBase64(bool $base64)
    {
        $this->base64 = $base64;

        return $this;
    }

    /**
     * @param string $raw
     * @return static
     * @throws \Exception
     */
    public function read(string $raw)
    {
        $this->validateClosing();

        $this->name   = '';
        $this->value  = $raw;
        $this->base64 = false;

        try {
            $prefix = static::NAMED_ARGUMENT_PREFIX . static::BASE_64_MARK;
            $nameAndValue64 = $this->giGetPSRFormatParser()->parseAfterPrefix($raw, $prefix, false);
        } catch (\Exception $exception) {
            try {
                $prefix = static::NAMED_ARGUMENT_PREFIX;
                $nameAndValue = $this->giGetPSRFormatParser()->parseAfterPrefix($raw, $prefix, false);
            } catch (\Exception $exception) {
                try {
                    $prefix = static::BASE_64_MARK;
                    $value64 = $this->giGetPSRFormatParser()->parseAfterPrefix($raw, $prefix, false);
                } catch (\Exception $exception) {}
            }
        }

        if (!empty($nameAndValue64)) {
            list($this->name, $this->value) = $this->giGetPSRFormatParser()->getSeparatedParts(
                $nameAndValue64, static::NAMED_ARGUMENT_SEPARATOR, $nameAndValue64, ''
            );

            $this->base64 = true;
        } elseif (!empty($nameAndValue)) {
            list($this->name, $this->value) = $this->giGetPSRFormatParser()->getSeparatedParts(
                $nameAndValue, static::NAMED_ARGUMENT_SEPARATOR, $nameAndValue, ''
            );
        } elseif (!empty($value64)) {
            $this->value  = $value64;
            $this->base64 = true;
        }

        if (!empty($this->value) && $this->base64) {
            $this->value = base64_decode($this->value);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        if ($this->isNamed() && $this->isBase64()) {
            $prefix = static::NAMED_ARGUMENT_PREFIX . static::BASE_64_MARK;
            $result = $prefix . $this->name . static::NAMED_ARGUMENT_SEPARATOR . base64_encode($this->value);
        } elseif ($this->isNamed() && !$this->isBase64()) {
            $result = static::NAMED_ARGUMENT_PREFIX . $this->name . static::NAMED_ARGUMENT_SEPARATOR . $this->value;
        } elseif (!$this->isNamed() && $this->isBase64()) {
            $result = static::BASE_64_MARK . base64_encode($this->value);
        } else {
            $result = $this->value;
        }

        return $result;
    }
}