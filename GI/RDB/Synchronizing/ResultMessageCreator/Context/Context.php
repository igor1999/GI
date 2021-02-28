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
namespace GI\RDB\Synchronizing\ResultMessageCreator\Context;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\CLI\Colorizing\ColorizingInterface;

class Context implements ContextInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @return string
     */
    public function getDumpForeground()
    {
        return ColorizingInterface::FOREGROUND_COLOR_WHITE;
    }

    /**
     * @return string
     */
    public function getDumpBackground()
    {
        return ColorizingInterface::BACKGROUND_COLOR_GREEN;
    }

    /**
     * @return string
     */
    public function getNoDiffForeground()
    {
        return ColorizingInterface::FOREGROUND_COLOR_WHITE;
    }

    /**
     * @return string
     */
    public function getNoDiffBackground()
    {
        return ColorizingInterface::BACKGROUND_COLOR_GREEN;
    }

    /**
     * @return string
     */
    public function getDiffForeground()
    {
        return ColorizingInterface::FOREGROUND_COLOR_BLACK;
    }

    /**
     * @return string
     */
    public function getDiffBackground()
    {
        return ColorizingInterface::BACKGROUND_COLOR_YELLOW;
    }

    /**
     * @return string
     */
    public function getErrorForeground()
    {
        return ColorizingInterface::FOREGROUND_COLOR_WHITE;
    }

    /**
     * @return string
     */
    public function getErrorBackground()
    {
        return ColorizingInterface::BACKGROUND_COLOR_RED;
    }
}