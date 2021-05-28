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
namespace GI\Util\SourceMaker\FromResource;

use GI\Util\SourceMaker\AbstractSourceMaker;
use GI\FileSystem\ContentTypes;

class FromResource extends AbstractSourceMaker implements FromResourceInterface
{
    /**
     * @param resource $resource
     * @param string $contentType
     * @return string
     * @throws \Exception
     */
    protected function createBinary($resource, string $contentType)
    {
        ob_start();

        switch ($contentType) {
            case ContentTypes::PNG:
                imagepng($resource);
                break;
            case ContentTypes::JPEG:
            case ContentTypes::JPG:
                imagejpeg($resource);
                break;
            case ContentTypes::GIF:
                imagegif($resource);
                break;
            default:
                break;
        }

        $binary = ob_get_clean();

        if (empty($binary)) {
            $this->getGiServiceLocator()->throwNotFoundException('MIME-type', $contentType);
        }

        return $binary;
    }

    /**
     * @param resource $resource
     * @param string $contentType
     * @return string
     * @throws \Exception
     */
    public function create($resource, string $contentType)
    {
        return $this->build($this->createBinary($resource, $contentType), $contentType);
    }
}