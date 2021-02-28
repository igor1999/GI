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
namespace GI\Email\Body;

use GI\Email\Body\Attachment\Attachment;
use GI\Email\Body\Multipart\Multipart;
use GI\Email\Body\Text\Text;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Email\Body\Attachment\AttachmentInterface;
use GI\Email\Body\Multipart\MultipartInterface;
use GI\Email\Body\Text\TextInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

class Body implements BodyInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var PartInterface[]
     */
    private $parts = [];


    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return array_key_exists($index, $this->parts);
    }

    /**
     * @param int $index
     * @return PartInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->giThrowNotInScopeException($index);
        }

        return $this->parts[$index];
    }

    /**
     * @return PartInterface[]
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->parts);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->parts);
    }

    /**
     * @param PartInterface $part
     * @return static
     */
    public function prepend(PartInterface $part)
    {
        array_unshift($this->parts, $part);

        return $this;
    }

    /**
     * @param PartInterface $part
     * @return static
     */
    public function append(PartInterface $part)
    {
        $this->parts[] = $part;

        return $this;
    }

    /**
     * @param int $index
     * @param PartInterface $part
     * @return static
     */
    public function insert(int $index, PartInterface $part)
    {
        if (!$this->has($index)) {
            $this->append($part);
        } else {
            array_splice($this->parts, $index, 0, [$part]);
        }

        return $this;
    }

    /**
     * @param FSOFileInterface $file
     * @param bool $base64Encoding
     * @return static
     */
    public function prependAttachment(FSOFileInterface $file, bool $base64Encoding = false)
    {
        $this->prepend($this->createAttachment($file, $base64Encoding));

        return $this;
    }

    /**
     * @param FSOFileInterface $file
     * @param bool $base64Encoding
     * @return static
     */
    public function appendAttachment(FSOFileInterface $file, bool $base64Encoding = false)
    {
        $this->append($this->createAttachment($file, $base64Encoding));

        return $this;
    }

    /**
     * @param int $index
     * @param FSOFileInterface $file
     * @param bool $base64Encoding
     * @return static
     */
    public function insertAttachment(int $index, FSOFileInterface $file, bool $base64Encoding = false)
    {
        $this->insert($index, $this->createAttachment($file, $base64Encoding));

        return $this;
    }

    /**
     * @param FSOFileInterface $file
     * @param bool $base64Encoding
     * @return AttachmentInterface
     */
    protected function createAttachment(FSOFileInterface $file, bool $base64Encoding)
    {
        try {
            $result = $this->giGetDi(AttachmentInterface::class, null, [$file, $base64Encoding]);
        } catch (\Exception $e) {
            $result = new Attachment($file, $base64Encoding);
        }

        return $result;
    }

    /**
     * @param string $text
     * @return static
     */
    public function prependText(string $text)
    {
        $this->prepend($this->createText($text));

        return $this;
    }

    /**
     * @param string $text
     * @return static
     */
    public function appendText(string $text)
    {
        $this->append($this->createText($text));

        return $this;
    }

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertText(int $index, string $text)
    {
        $this->insert($index, $this->createText($text));

        return $this;
    }

    /**
     * @param string $text
     * @return TextInterface
     */
    protected function createText(string $text)
    {
        try {
            $result = $this->giGetDi(TextInterface::class, null, [$text]);
        } catch (\Exception $e) {
            $result = new Text($text);
        }

        return $result;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index)
    {
        $result = $this->has($index);

        if ($result) {
            array_splice($this->parts, $index, 1);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->parts = [];

        return $this;
    }

    /**
     * @return array
     */
    public function extract()
    {
        $f = function(PartInterface $part)
        {
            return $part->extract();
        };

        $result = array_map($f, $this->parts);

        if (count($this->parts) > 1) {
            array_unshift($result, $this->createMultipart()->extract());
        }

        return $result;
    }

    /**
     * @return MultipartInterface
     */
    protected function createMultipart()
    {
        try {
            $result = $this->giGetDi(MultipartInterface::class);
        } catch (\Exception $e) {
            $result = new Multipart();
        }

        return $result;
    }
}