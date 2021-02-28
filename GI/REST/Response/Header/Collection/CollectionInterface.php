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

use GI\Pattern\StringConvertable\StringConvertableInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

use GI\REST\Response\Header\Attachment\Disposition\DispositionInterface;
use GI\REST\Response\Header\Attachment\Length\LengthInterface;
use GI\REST\Response\Header\Common\CommonInterface;
use GI\REST\Response\Header\HeaderInterface;
use GI\REST\Response\Header\ContentType\ContentTypeInterface;
use GI\REST\Response\Header\Location\LocationInterface;
use GI\REST\Response\Header\Refresh\RefreshInterface;
use GI\REST\Response\Header\Status\StatusInterface;

/**
 * Interface CollectionInterface
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
interface CollectionInterface extends StringConvertableInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return HeaderInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return HeaderInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param HeaderInterface $item
     * @return static
     */
    public function addInstance(HeaderInterface $item);

    /**
     * @param string $contentType
     * @param FSOFileInterface $file
     * @return static
     */
    public function addDownloadHeaders(string $contentType, FSOFileInterface $file);

    /**
     * @param CollectionInterface $collection
     * @return static
     */
    public function merge(CollectionInterface $collection);

    /**
     * @param string $key
     * @return static
     */
    public function remove(string $key);

    /**
     * @return static
     */
    public function clean();

    /**
     * @return string[]
     */
    public function getHeadersAsString();

    /**
     * @return static
     */
    public function send();
}