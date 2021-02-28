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

use GI\CLI\CLIInterface;

/**
 * Interface ColorizingInterface
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
interface ColorizingInterface extends CLIInterface
{
    const FOREGROUND_COLOR_BLACK         = '0;30';

    const FOREGROUND_COLOR_DARK_GREY     = '1;30';

    const FOREGROUND_COLOR_LIGHT_GREY    = '0;37';

    const FOREGROUND_COLOR_RED           = '0;31';

    const FOREGROUND_COLOR_LIGHT_RED     = '1;31';

    const FOREGROUND_COLOR_GREEN         = '0;32';

    const FOREGROUND_COLOR_LIGHT_GREEN   = '1;32';

    const FOREGROUND_COLOR_BROWN         = '0;33';

    const FOREGROUND_COLOR_YELLOW        = '1;33';

    const FOREGROUND_COLOR_BLUE          = '0;34';

    const FOREGROUND_COLOR_LIGHT_BLUE    = '1;34';

    const FOREGROUND_COLOR_MAGENTA       = '0;35';

    const FOREGROUND_COLOR_LIGHT_MAGENTA = '1;35';

    const FOREGROUND_COLOR_CYAN          = '0;36';

    const FOREGROUND_COLOR_LIGHT_CYAN    = '1;36';

    const FOREGROUND_COLOR_WHITE         = '1;37';


    const BACKGROUND_COLOR_BLACK      = '40';

    const BACKGROUND_COLOR_RED        = '41';

    const BACKGROUND_COLOR_GREEN      = '42';

    const BACKGROUND_COLOR_YELLOW     = '43';

    const BACKGROUND_COLOR_BLUE       = '44';

    const BACKGROUND_COLOR_MAGENTA    = '45';

    const BACKGROUND_COLOR_CYAN       = '46';

    const BACKGROUND_COLOR_LIGHT_GREY = '47';


    const FOREGROUND_SETTER_PREFIX = 'setForegroundTo';

    const FOREGROUND_CONST_PREFIX  = 'FOREGROUND_COLOR_';

    const BACKGROUND_SETTER_PREFIX = 'setBackgroundTo';

    const BACKGROUND_CONST_PREFIX  = 'BACKGROUND_COLOR_';


    /**
     * @return string
     */
    public function getForeground();

    /**
     * @return static
     */
    public function clearForeground();

    /**
     * @return string
     */
    public function getBackground();

    /**
     * @return static
     */
    public function clearBackground();

    /**
     * @return bool
     */
    public function isOn();

    /**
     * @param string $string
     * @param string|null $foregroundColor
     * @param string|null $backgroundColor
     * @return string
     */
    public function colorize(string $string, string $foregroundColor = null, string $backgroundColor = null);
}