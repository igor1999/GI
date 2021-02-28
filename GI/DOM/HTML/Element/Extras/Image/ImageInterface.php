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

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

interface ImageInterface
{
    /**
     * @param string $src
     * @return static
     */
    public function setSrc(string $src);

    /**
     * @param FSOFileInterface $file
     * @return static
     * @throws \Exception
     */
    public function setSrcFromFile(FSOFileInterface $file);

    /**
     * @param resource $resource
     * @param string $contentType
     * @return static
     * @throws \Exception
     */
    public function setSrcFromResource($resource, string $contentType);

    /**
     * @param string $alt
     * @return static
     */
    public function setAlt(string $alt);
}