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
namespace GI\DOM\HTML\Element\Extras\Image;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\DOM\HTML\Element\HTMLInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

trait ImageTrait
{
    /**
     * @param string $src
     * @return static
     */
    public function setSrc(string $src)
    {
        if ($this instanceof HTMLInterface) {
            $this->getAttributes()->setSrc($src);
        } else {
            trigger_error('Class should implement HTMLInterface: ' . static::class, E_USER_ERROR);
        }

        return $this;
    }

    /**
     * @param FSOFileInterface $file
     * @return static
     * @throws \Exception
     */
    public function setSrcFromFile(FSOFileInterface $file)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $this->setSrc($me->giGetFromFileSourceMaker()->create($file));

        return $this;
    }

    /**
     * @param resource $resource
     * @param string $contentType
     * @return static
     * @throws \Exception
     */
    public function setSrcFromResource($resource, string $contentType)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $this->setSrc($me->giGetFromResourceSourceMaker()->create($resource, $contentType));

        return $this;
    }

    /**
     * @param string $alt
     * @return static
     */
    public function setAlt(string $alt)
    {
        if ($this instanceof HTMLInterface) {
            $this->getAttributes()->setAlt($alt);
        } else {
            trigger_error('Class should implement HTMLInterface: ' . static::class, E_USER_ERROR);
        }

        return $this;
    }
}