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
namespace GI\REST\Response\Header\Collection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\REST\Response\Header\Factory\FactoryInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\REST\Response\Header\HeaderInterface;

use GI\REST\Response\Header\Attachment\Disposition\DispositionInterface;
use GI\REST\Response\Header\Attachment\Length\LengthInterface;
use GI\REST\Response\Header\Common\CommonInterface;
use GI\REST\Response\Header\ContentType\ContentTypeInterface;
use GI\REST\Response\Header\Location\LocationInterface;
use GI\REST\Response\Header\Refresh\RefreshInterface;
use GI\REST\Response\Header\Status\StatusInterface;

/**
 * Class Collection
 * @package GI\REST\Response\Header\Collection
 *
 * @method CommonInterface getCommon()
 * @method DispositionInterface getAttachmentDisposition()
 * @method LengthInterface getAttachmentLength()
 * @method ContentTypeInterface getContentType()
 * @method LocationInterface getLocation()
 * @method RefreshInterface getRefresh()
 * @method StatusInterface getStatus()
 *
 * @method CollectionInterface addCommon(string $key, string $content)
 * @method CollectionInterface addAttachmentDisposition(FSOFileInterface $file)
 * @method CollectionInterface addAttachmentLength(FSOFileInterface $file)
 * @method CollectionInterface addContentType(string $type)
 * @method CollectionInterface addLocation(string $url)
 * @method CollectionInterface addRefresh(int $time, string $url)
 * @method CollectionInterface addStatus(int $code, string $protocol = '')
 *
 * @method bool removeCommon()
 * @method bool removeAttachmentDisposition()
 * @method bool removeAttachmentLength()
 * @method bool removeContentType()
 * @method bool removeLocation()
 * @method bool removeRefresh()
 * @method bool removeStatus()
 */
class Collection implements CollectionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var HeaderInterface[]
     */
    private $items = [];


    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @return HeaderInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @return HeaderInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->giGetResponseFactory()->getHeaderFactory();
    }

    /**
     * @param HeaderInterface $item
     * @return static
     */
    public function addInstance(HeaderInterface $item)
    {
        $this->items[$item->getCollectionKey()] = $item;

        return $this;
    }

    /**
     * @param string $contentType
     * @param FSOFileInterface $file
     * @return static
     */
    public function addDownloadHeaders(string $contentType, FSOFileInterface $file)
    {
        $download = $this->getFactory()->createDownload($contentType, $file);

        $this->merge($download);

        return $this;
    }

    /**
     * @param CollectionInterface $collection
     * @return static
     */
    public function merge(CollectionInterface $collection)
    {
        foreach ($collection->getItems() as $item) {
            $this->addInstance($item);
        }

        return $this;
    }

    /**
     * @param string $key
     * @return static
     */
    public function remove(string $key)
    {
        if ($result = $this->has($key)) {
            unset($this->items[$key]);
        }

        return $this;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @return string[]
     */
    public function getHeadersAsString()
    {
        $f = function(HeaderInterface $item)
        {
            return $item->toString();
        };

        return array_map($f, $this->items);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return implode(PHP_EOL, $this->getHeadersAsString());
    }

    /**
     * @return static
     */
    public function send()
    {
        foreach ($this->items as $item) {
            $item->send();
        }

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return static|HeaderInterface|bool
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $get = $this->giGetPSRFormatParser()->parseWithPrefixGet($method, '', false);
        } catch (\Exception $exception) {
            try {
                $add = $this->giGetPSRFormatParser()->parseWithPrefixAdd($method, '', false);
            } catch (\Exception $exception) {
                try {
                    $remove = $this->giGetPSRFormatParser()->parseWithPrefixRemove($method, '', false);
                } catch (\Exception $exception) {
                    $this->giThrowMagicMethodException($method);
                }
            }
        }

        $result = null;

        if (!empty($get)) {
            $key    = $this->getFactory()->get($get)->getClass();
            $result = $this->get($key);
        } elseif (!empty($add)) {
            $instance = $this->getFactory()->get($add)->get($arguments);
            $result   = $this->addInstance($instance);
        } elseif (!empty($remove)) {
            $key    = $this->getFactory()->get($remove)->getClass();
            $result = $this->remove($key);
        }

        return $result;
    }
}