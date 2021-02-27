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
namespace GI\Security\Captcha\ImageText\Graphic\Context;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\Security\Captcha\Base\Graphic\Context\ContextInterface as BaseInterface;

interface ContextInterface extends BaseInterface
{
    /**
     * @return int
     */
    public function getRedColor();

    /**
     * @return int
     */
    public function getGreenColor();

    /**
     * @return int
     */
    public function getBlueColor();

    /**
     * @return int
     */
    public function getOpaque();

    /**
     * @return int
     */
    public function getMinAngle();

    /**
     * @return int
     */
    public function getMaxAngle();

    /**
     * @return int
     */
    public function getCoordinateX();

    /**
     * @return int
     */
    public function getCoordinateY();

    /**
     * @return int
     */
    public function getMinDeltaX();

    /**
     * @return int
     */
    public function getMaxDeltaX();

    /**
     * @return int
     */
    public function getMinDeltaY();

    /**
     * @return int
     */
    public function getMaxDeltaY();

    /**
     * @return int
     */
    public function getTtfSize();

    /**
     * @return FSOFileInterface
     */
    public function getTtfFile();
}