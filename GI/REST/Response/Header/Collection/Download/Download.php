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
namespace GI\REST\Response\Header\Collection\Download;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\REST\Response\Header\Collection\Collection;

class Download extends Collection implements DownloadInterface
{
    /**
     * Download constructor.
     * @param string $contentType
     * @param FSOFileInterface $file
     */
    public function __construct(string $contentType, FSOFileInterface $file)
    {
        $this->addContentType($contentType)
            ->addCommon('Content-Description', 'File Transfer')
            ->addAttachmentDisposition($file)
            ->addCommon('Expires', '0')
            ->addCommon('Cache-Control', 'must-revalidate')
            ->addCommon('Pragma', 'public')
            ->addAttachmentLength($file);
    }
}