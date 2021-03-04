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

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\REST\Request\Upload\UploadTrait;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSOInterface;

class Item implements ItemInterface
{
    use ServiceLocatorAwareTrait, UploadTrait;


    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $mimeType = '';

    /**
     * @var string
     */
    private $tmpName = '';

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $error = 0;


    /**
     * @param string $name
     * @param string $mimeType
     * @param string $tmpName
     * @param int $size
     * @param int $error
     */
    public function __construct(string $name, string $mimeType, string $tmpName, int $size, int $error = 0)
    {
        $this->name     = $name;
        $this->mimeType = $mimeType;
        $this->tmpName  = $tmpName;
        $this->size     = (int)$size;

        if (is_numeric($error) && $error >= 0) {
            $this->error = (int)$error;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getTmpName()
    {
        return $this->tmpName;
    }

    /**
     * @return FSOFileInterface
     */
    public function getTmpFile()
    {
        return $this->giCreateFSOFile($this->tmpName);
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param array $types
     * @return boolean
     */
    public function validateMimeType(array $types)
    {
        return in_array($this->mimeType, $types);
    }

    /**
     * @param int|null $min
     * @param int|null $max
     * @return boolean
     */
    public function validateSize(int $min = null, int $max = null)
    {
        $minRequested = is_numeric($min) && $min >= 0;
        $maxRequested = is_numeric($max) && $max >= 0;

        return (!$minRequested || $min <= $this->size) && (!$maxRequested || $this->size <= $max);
    }

    /**
     * @return boolean
     */
    public function validateError()
    {
        return $this->error != 0;
    }

    /**
     * @return bool
     */
    public function remove()
    {
        $file   = $this->getTmpFile();
        $result = $file->exists();

        $file->delete();

        return $result;
    }

    /**
     * @param FSOInterface $target
     * @return static
     * @throws \Exception
     */
    public function upload(FSOInterface $target)
    {
        if ($target instanceof FSODirInterface) {
            $file = $this->getTmpFile();
            $destination = $target->createChildFile($file->getBasename());
            $file->upload($destination);
        } elseif ($target instanceof FSOFileInterface) {
            $this->getTmpFile()->upload($target);
        } else {
            $this->giThrowInvalidTypeException('FSO', $target->getPath(), 'file or dir');
        }

        return $this;
    }

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $contents)
    {
        $item = $this->createCreator()->create($contents);

        if (!($item instanceof ItemInterface)) {
            $this->giThrowInvalidTypeException('Item', get_class($item), ItemInterface::class);
        }

        $this->name     = $item->getName();
        $this->mimeType = $item->getMimeType();
        $this->tmpName  = $item->getTmpName();
        $this->size     = $item->getSize();
        $this->error    = $item->getError();

        return $this;
    }

    /**
     * @return array
     */
    public function extract()
    {
        return [
            'name'     => $this->getName(),
            'type'     => $this->getMimeType(),
            'tmp_name' => $this->getTmpName(),
            'size'     => $this->getSize(),
            'error'    => $this->getError(),
        ];
    }
}