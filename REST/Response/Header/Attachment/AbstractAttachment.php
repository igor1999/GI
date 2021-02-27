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
namespace GI\REST\Response\Header\Attachment;

use GI\REST\Response\Header\AbstractHeader;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

abstract class AbstractAttachment extends AbstractHeader implements AttachmentInterface
{
    /**
     * @var FSOFileInterface
     */
    private $file;


    /**
     * AttachmentLength constructor.
     * @param string $key
     * @param FSOFileInterface $file
     */
    public function __construct(string $key, FSOFileInterface $file)
    {
        $this->file = $file;

        parent::__construct($key, $this->file->getPath());
    }

    /**
     * @return FSOFileInterface
     */
    public function getFile()
    {
        return $this->file;
    }
}