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
namespace GI\CLI\Colorizing;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\CLI\Colorizing\Context\ContextInterface;

/**
 * Class Colorizing
 * @package GI\CLI\Colorizing
 *
 * @method ColorizingInterface setForegroundToBlack()
 * @method ColorizingInterface setForegroundToDarkGrey()
 * @method ColorizingInterface setForegroundToLightGrey()
 * @method ColorizingInterface setForegroundToRed()
 * @method ColorizingInterface setForegroundToLightRed()
 * @method ColorizingInterface setForegroundToGreen()
 * @method ColorizingInterface setForegroundToLightGreen()
 * @method ColorizingInterface setForegroundToBrown()
 * @method ColorizingInterface setForegroundToYellow()
 * @method ColorizingInterface setForegroundToBlue()
 * @method ColorizingInterface setForegroundToLightBlue()
 * @method ColorizingInterface setForegroundToMagenta()
 * @method ColorizingInterface setForegroundToLightMagenta()
 * @method ColorizingInterface setForegroundToCyan()
 * @method ColorizingInterface setForegroundToLightCyan()
 * @method ColorizingInterface setForegroundToWhite()
 *
 * @method ColorizingInterface setBackgroundToBlack()
 * @method ColorizingInterface setBackgroundToRed()
 * @method ColorizingInterface setBackgroundToGreen()
 * @method ColorizingInterface setBackgroundToYellow()
 * @method ColorizingInterface setBackgroundToBlue()
 * @method ColorizingInterface setBackgroundToMagenta()
 * @method ColorizingInterface setBackgroundToCyan()
 * @method ColorizingInterface setBackgroundToLightGrey()
 */
class Colorizing implements ColorizingInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $foreground = '';

    /**
     * @var string
     */
    private $background = '';

    /**
     * @var bool
     */
    private $on = true;


    /**
     * Colorizing constructor.
     */
    public function __construct()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);

            $this->on = $context->isOn();
        } catch (\Exception $e) {}
    }

    /**
     * @return string
     */
    public function getForeground()
    {
        return $this->foreground;
    }

    /**
     * @param string $foreground
     * @return static
     */
    protected function setForeground(string $foreground)
    {
        $this->foreground = $foreground;

        return $this;
    }

    /**
     * @return static
     */
    public function clearForeground()
    {
        $this->setForeground(null);

        return $this;
    }

    /**
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @param string $background
     * @return static
     */
    protected function setBackground(string $background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * @return static
     */
    public function clearBackground()
    {
        $this->setBackground(null);

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return static
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $foreground = $this->parseColor($method, true);
        } catch (\Exception $e) {
            try {
                $background = $this->parseColor($method, false);
            } catch (\Exception $e) {
                $this->giThrowMagicMethodException($method);
            }
        }

        if (!empty($foreground)) {
            $this->setForeground($foreground);
        } elseif (!empty($background)) {
            $this->setBackground($background);
        }

        return $this;
    }

    /**
     * @param string $method
     * @param bool $foreground
     * @return mixed
     * @throws \Exception
     */
    protected function parseColor($method, $foreground = true)
    {
        $setterPrefix = $foreground ? self::FOREGROUND_SETTER_PREFIX : self::BACKGROUND_SETTER_PREFIX;
        $constPrefix  = $foreground ? self::FOREGROUND_CONST_PREFIX : self::BACKGROUND_CONST_PREFIX;

        try {
            $const = $this->giGetPSRFormatParser()->parseAfterPrefix($method, $setterPrefix);
        } catch (\Exception $exception) {
            $const = null;
            $this->giThrowMagicMethodException($method);
        }

        $const = $this->giGetCamelCaseConverter()->convertToUnderlineUpperCase($const);
        $const = $constPrefix . $const;

        return $this->giGetClassMeta(ColorizingInterface::class)->getConstants()->get($const);
    }

    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->on;
    }

    /**
     * @param bool $on
     * @return static
     */
    protected function setOn(bool $on)
    {
        $this->on = $on;

        return $this;
    }

    /**
     * @return array
     */
    protected function getForegroundColors()
    {
        return [
            self::FOREGROUND_COLOR_BLACK,
            self::FOREGROUND_COLOR_DARK_GREY,
            self::FOREGROUND_COLOR_LIGHT_GREY,
            self::FOREGROUND_COLOR_RED,
            self::FOREGROUND_COLOR_LIGHT_RED,
            self::FOREGROUND_COLOR_GREEN,
            self::FOREGROUND_COLOR_LIGHT_GREEN,
            self::FOREGROUND_COLOR_BROWN,
            self::FOREGROUND_COLOR_YELLOW,
            self::FOREGROUND_COLOR_BLUE,
            self::FOREGROUND_COLOR_LIGHT_BLUE,
            self::FOREGROUND_COLOR_MAGENTA,
            self::FOREGROUND_COLOR_LIGHT_MAGENTA,
            self::FOREGROUND_COLOR_CYAN,
            self::FOREGROUND_COLOR_LIGHT_CYAN,
            self::FOREGROUND_COLOR_WHITE,
        ];
    }

    /**
     * @return array
     */
    protected function getBackgroundColors()
    {
        return [
            self::BACKGROUND_COLOR_BLACK,
            self::BACKGROUND_COLOR_RED,
            self::BACKGROUND_COLOR_GREEN,
            self::BACKGROUND_COLOR_YELLOW,
            self::BACKGROUND_COLOR_BLUE,
            self::BACKGROUND_COLOR_MAGENTA,
            self::BACKGROUND_COLOR_CYAN,
            self::BACKGROUND_COLOR_LIGHT_GREY,
        ];
    }

    /**
     * @param string $string
     * @param string|null $foregroundColor
     * @param string|null $backgroundColor
     * @return string
     */
    public function colorize(string $string, string $foregroundColor = null, string $backgroundColor = null)
    {
        if ($this->on) {
            if (empty($foregroundColor)) {
                $foregroundColor = $this->foreground;
            }

            if (empty($backgroundColor)) {
                $foregroundColor = $this->background;
            }

            $foregrounds = $this->getForegroundColors();
            $backgrounds = $this->getBackgroundColors();

            $colors = [
                array_search($foregroundColor, $foregrounds) !== false ? $foregroundColor : null,
                array_search($backgroundColor, $backgrounds) !== false ? $backgroundColor : null,
            ];
            $colors = array_filter($colors);

            if (!empty($colors)) {
                $string = chr(27) . '[' . implode(';', $colors) . 'm' . $string . chr(27) . '[0m';
            }
        }

        return $string;
    }
}