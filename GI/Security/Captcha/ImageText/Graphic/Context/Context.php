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

use GI\Security\Captcha\Base\Graphic\Context\AbstractContext;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

class Context extends AbstractContext implements ContextInterface
{
    const DEFAULT_RED_COLOR   = 60;

    const DEFAULT_GREEN_COLOR = 60;

    const DEFAULT_BLUE_COLOR  = 60;

    const DEFAULT_OPAQUE      = 0;


    const DEFAULT_MIN_ANGLE = -10;

    const DEFAULT_MAX_ANGLE = 10;


    const DEFAULT_COORDINATE_X = 10;

    const DEFAULT_COORDINATE_Y = 30;


    const DEFAULT_MIN_DELTA_X = 10;

    const DEFAULT_MAX_DELTA_X = 20;

    const DEFAULT_MIN_DELTA_Y = -2;

    const DEFAULT_MAX_DELTA_Y = 2;


    const DEFAULT_TTF_SIZE = 25;


    const PATH_TO_TTF_FILE   = 'source/captcha.ttf';

    const PATH_TO_BASE_IMAGE = 'source/captcha-base-image.png';


    /**
     * @return int
     */
    public function getRedColor()
    {
        return self::DEFAULT_RED_COLOR;
    }

    /**
     * @return int
     */
    public function getGreenColor()
    {
        return self::DEFAULT_GREEN_COLOR;
    }

    /**
     * @return int
     */
    public function getBlueColor()
    {
        return self::DEFAULT_BLUE_COLOR;
    }

    /**
     * @return int
     */
    public function getOpaque()
    {
        return self::DEFAULT_OPAQUE;
    }

    /**
     * @return int
     */
    public function getMinAngle()
    {
        return self::DEFAULT_MIN_ANGLE;
    }

    /**
     * @return int
     */
    public function getMaxAngle()
    {
        return self::DEFAULT_MAX_ANGLE;
    }

    /**
     * @return int
     */
    public function getCoordinateX()
    {
        return self::DEFAULT_COORDINATE_X;
    }

    /**
     * @return int
     */
    public function getCoordinateY()
    {
        return self::DEFAULT_COORDINATE_Y;
    }

    /**
     * @return int
     */
    public function getMinDeltaX()
    {
        return self::DEFAULT_MIN_DELTA_X;
    }

    /**
     * @return int
     */
    public function getMaxDeltaX()
    {
        return self::DEFAULT_MAX_DELTA_X;
    }

    /**
     * @return int
     */
    public function getMinDeltaY()
    {
        return self::DEFAULT_MIN_DELTA_Y;
    }

    /**
     * @return int
     */
    public function getMaxDeltaY()
    {
        return self::DEFAULT_MAX_DELTA_Y;
    }

    /**
     * @return int
     */
    public function getTtfSize()
    {
        return self::DEFAULT_TTF_SIZE;
    }

    /**
     * @return FSOFileInterface
     */
    public function getTtfFile()
    {
        return $this->giCreateClassDirChildFile(self::class, static::PATH_TO_TTF_FILE);
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateTTFFile()
    {
        if (!($this->getTtfFile() instanceof FSOFileInterface)) {
            $this->giThrowNotSetException('Captcha TTF-file');
        }

        $this->getTtfFile()->fireInexistence();
    }

    /**
     * @return FSOFileInterface
     */
    public function getBaseImage()
    {
        return $this->giCreateClassDirChildFile(self::class, static::PATH_TO_BASE_IMAGE);
    }
}