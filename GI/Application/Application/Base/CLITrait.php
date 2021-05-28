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
namespace GI\Application\Application\Base;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\CLI\Colorizing\ColorizingInterface;

trait CLITrait
{
    /**
     * @return static
     */
    protected function handleDefault()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        echo $me->getGiServiceLocator()->getCLIFactory()->createColorizing()->colorize(
            $this->getCLIDefaultMessage(),
            $this->getCLIForegroundColor(),
            $this->getCLIBackgroundColor()
        );

        return $this;
    }

    /**
     * @return string
     */
    protected function getCLIDefaultMessage()
    {
        return 'Call not found';
    }

    /**
     * @return string
     */
    protected function getCLIForegroundColor()
    {
        return ColorizingInterface::FOREGROUND_COLOR_BLACK;
    }

    /**
     * @return string
     */
    protected function getCLIBackgroundColor()
    {
        return ColorizingInterface::BACKGROUND_COLOR_RED;
    }
}