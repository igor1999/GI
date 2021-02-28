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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

class Attachment implements AttachmentInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var FSOFileInterface
     */
    private $file;

    /**
     * @var bool
     */
    private $base64Encoding;


    /**
     * Attachment constructor.
     *
     * @param FSOFileInterface $file
     * @param bool $base64Encoding
     */
    public function __construct(FSOFileInterface $file, bool $base64Encoding = false)
    {
        $this->setFile($file)->setBase64Encoding($base64Encoding);
    }

    /**
     * @return FSOFileInterface
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param FSOFileInterface $file
     * @return static
     */
    public function setFile(FSOFileInterface $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBase64Encoding()
    {
        return $this->base64Encoding;
    }

    /**
     * @param bool $base64Encoding
     * @return static
     */
    public function setBase64Encoding(bool $base64Encoding)
    {
        $this->base64Encoding = $base64Encoding;

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function extract()
    {
        list($type, $subtype) = $this->getFile()->getMeta()->getMimeTypeContents();

        $basename = $this->getFile()->getBasename();
        $contents = $this->getFile()->readAndClose();

        return [
            'type'             => $this->getExtractionForType($type),
            'encoding'         => $this->isBase64Encoding() ? ENCBASE64 : ENCBINARY,
            'subtype'          => $subtype,
            'description'      => $basename,
            'disposition.type' => 'attachment',
            'disposition'      => ['filename' => $basename],
            'type.parameters'  => ['name' => $basename],
            'contents.data'    => $this->isBase64Encoding() ? base64_encode($contents) : $contents,
        ];
    }

    /**
     * @param string $type
     * @return int
     */
    protected function getExtractionForType(string $type)
    {
        switch ($type)
        {
            case "image":
                $result = TYPEIMAGE;
                break;
            case "text":
                $result = TYPETEXT;
                break;
            case "audio":
                $result = TYPEAUDIO;
                break;
            default:
                $result = TYPEAPPLICATION;
                break;
        }

        return $result;
    }
}