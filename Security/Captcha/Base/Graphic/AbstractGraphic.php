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
namespace GI\Security\Captcha\Base\Graphic;

use GI\FileSystem\ContentTypes;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Security\Captcha\Base\Graphic\Context\ContextInterface;

abstract class AbstractGraphic implements GraphicInterface
{
    use ServiceLocatorAwareTrait;


    const MIME_TYPE_PNG  = ContentTypes::PNG;

    const MIME_TYPE_JPEG = ContentTypes::JPEG;

    const MIME_TYPE_JPG  = ContentTypes::JPG;

    const MIME_TYPE_GIF  = ContentTypes::GIF;


    /**
     * @var mixed
     */
    private $value;

    /**
     * @var resource
     */
    private $imageResource;


    /**
     * AbstractGraphic constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createContext()->getContext()->validateProperties();
    }

    /**
     * @return static
     */
    abstract protected function createContext();

    /**
     * @return ContextInterface
     */
    abstract protected function getContext();

    /**
     * @return resource
     */
    abstract protected function create();

    /**
     * @return mixed
     */
    protected function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value)
    {
        $this->value = $value;

        $this->imageResource = $this->create();

        return $this;
    }

    /**
     * @return resource
     * @throws \Exception
     */
    public function getImageResource()
    {
        if (!is_resource($this->imageResource)) {
            $this->giThrowNotSetException('Image resource');
        }

        return $this->imageResource;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMimeType()
    {
        return $this->getContext()->getBaseImage()->getMeta()->getMimeType();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getBase64EncodedImage()
    {
        return $this->giGetFromResourceSourceMaker()->create($this->imageResource, $this->getMimeType());
    }

    /**
     * @return resource
     * @throws \Exception
     */
    protected function getImageContext()
    {
        $mimeType = $this->getMimeType();
        $path     = $this->getContext()->getBaseImage()->getPath();

        switch ($mimeType) {
            case static::MIME_TYPE_PNG:
                $result = imagecreatefrompng($path);
                break;
            case static::MIME_TYPE_JPEG:
            case static::MIME_TYPE_JPG:
                $result = imagecreatefromjpeg($path);
                break;
            case static::MIME_TYPE_GIF:
                $result = imagecreatefromgif($path);
                break;
            default:
                $result = null;
                $this->giThrowInvalidTypeException('Captcha image MIME-type', $mimeType, 'png/jpg/jpeg/gif');
        }

        return $result;
    }
}