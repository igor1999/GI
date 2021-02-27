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
namespace GI\Markup\Reader;

use GI\Markup\Reader\Base\CollectionInterface;
use GI\Util\TextProcessing\Encoding\EncodingInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\Util\TextProcessing\XML\Version\VersionInterface;

interface ReaderInterface extends CollectionInterface, EncodingInterface, VersionInterface
{
    /**
     * @return \DOMDocument
     */
    public function createDOMDocument();

    /**
     * @param FSOFileInterface $file
     * @return array
     */
    public function readFile(FSOFileInterface $file);

    /**
     * @param string $xml
     * @return array
     */
    public function readString(string $xml);
}