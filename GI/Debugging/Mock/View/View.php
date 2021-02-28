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
namespace GI\Debugging\Mock\View;

use GI\Debugging\Base\View\AbstractView as Base;

class View extends Base implements ViewInterface
{
    const PATH_TO_IMAGE = 'img/error.png';


    const MESSAGE = 'Unexpected server error';


    /**
     * @return string
     * @throws \Exception
     */
    public function createImageSource()
    {
        $source = $this->giCreateClassDirChildFile(static::class, static::PATH_TO_IMAGE);

        return $this->giGetFromFileSourceMaker()->create($source);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return static::MESSAGE;
    }
}