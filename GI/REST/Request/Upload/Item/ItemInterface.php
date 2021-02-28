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
namespace GI\REST\Request\Upload\Item;

use GI\REST\Request\Upload\UploadInterface;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\FSO\FSOInterface;

interface ItemInterface extends UploadInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getMimeType();

    /**
     * @return string
     */
    public function getTmpName();

    /**
     * @return FSOFileInterface
     */
    public function getTmpFile();

    /**
     * @return int
     */
    public function getSize();

    /**
     * @return int
     */
    public function getError();

    /**
     * @param FSOInterface $target
     * @return static
     * @throws \Exception
     */
    public function upload(FSOInterface $target);

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $contents);
}