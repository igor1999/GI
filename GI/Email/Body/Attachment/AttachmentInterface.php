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
namespace GI\Email\Body\Attachment;

use GI\Email\Body\PartInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

interface AttachmentInterface extends PartInterface
{
    /**
     * @return FSOFileInterface
     */
    public function getFile();

    /**
     * @param FSOFileInterface $file
     * @return static
     */
    public function setFile(FSOFileInterface $file);

    /**
     * @return bool
     */
    public function isBase64Encoding();

    /**
     * @param bool $base64Encoding
     * @return static
     */
    public function setBase64Encoding(bool $base64Encoding);

    /**
     * @return array
     * @throws \Exception
     */
    public function extract();
}