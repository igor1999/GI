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
namespace GI\DOM\HTML\Element\Image;

use GI\DOM\HTML\Element\SimpleElement;

use GI\DOM\HTML\Element\Extras\Image\ImageTrait;

class Image extends SimpleElement implements ImageInterface
{
    use ImageTrait;


    const TAG = 'img';


    /**
     * Image constructor.
     *
     * @param string $src
     * @param string $alt
     */
    public function __construct(string $src = '', string $alt = '')
    {
        parent::__construct(static::TAG);

        $this->setSrc($src)->setAlt($alt);
    }
}