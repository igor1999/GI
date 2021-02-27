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
namespace GI\DOM\HTML\Element\Graphic\Canvas;

use GI\DOM\HTML\Element\EmptyElement;

class Canvas extends EmptyElement implements CanvasInterface
{
    const TAG = 'canvas';


    /**
     * Canvas constructor.
     * @param string $width
     * @param string $height
     */
    public function __construct(string $width, string $height)
    {
        parent::__construct(static::TAG);

        $this->setWidth($width)->setHeight($height);
    }

    /**
     * @param string $width
     * @return static
     */
    public function setWidth(string $width)
    {
        $this->getStyle()->setWidth($width);

        return $this;
    }

    /**
     * @param string $height
     * @return static
     */
    public function setHeight(string $height)
    {
        $this->getStyle()->setHeight($height);

        return $this;
    }
}