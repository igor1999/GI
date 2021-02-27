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
namespace GI\REST\Response\Header\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\REST\Response\Header\Common\Common;

use GI\REST\Response\Header\Collection\Collection;
use GI\REST\Response\Header\Collection\Download\Download;

use GI\REST\Response\Header\Attachment\Disposition\Disposition as AttachmentDisposition;
use GI\REST\Response\Header\Attachment\Length\Length as AttachmentLength;
use GI\REST\Response\Header\ContentType\ContentType;
use GI\REST\Response\Header\Location\Location;
use GI\REST\Response\Header\Refresh\Refresh;
use GI\REST\Response\Header\Status\Status;


use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\REST\Response\Header\HeaderInterface;

use GI\REST\Response\Header\Common\CommonInterface;

use GI\REST\Response\Header\Collection\CollectionInterface;
use GI\REST\Response\Header\Collection\Download\DownloadInterface;

use GI\REST\Response\Header\Attachment\Disposition\DispositionInterface as AttachmentDispositionInterface;
use GI\REST\Response\Header\Attachment\Length\LengthInterface as AttachmentLengthInterface;
use GI\REST\Response\Header\ContentType\ContentTypeInterface;
use GI\REST\Response\Header\Location\LocationInterface;
use GI\REST\Response\Header\Refresh\RefreshInterface;
use GI\REST\Response\Header\Status\StatusInterface;

/**
 * Class Factory
 * @package GI\REST\Response\Header\Factory
 *
 * @method CommonInterface createCommon(string $key, string $content)
 *
 * @method CollectionInterface createCollection()
 * @method DownloadInterface createDownload(string $contentType, FSOFileInterface $file)
 *
 * @method AttachmentDispositionInterface createAttachmentDisposition(FSOFileInterface $file)
 * @method AttachmentLengthInterface createAttachmentLength(FSOFileInterface $file)
 * @method ContentTypeInterface createContentType(string $type)
 * @method LocationInterface createLocation(string $url)
 * @method RefreshInterface createRefresh(int $time, string $url)
 * @method StatusInterface createStatus(int $code, string $protocol = '')
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(HeaderInterface::class)->add(CollectionInterface::class);

        $this->set(Common::class)
            ->set(Collection::class)
            ->set(Download::class)
            ->setNamed('AttachmentDisposition',AttachmentDisposition::class)
            ->setNamed('AttachmentLength',AttachmentLength::class)
            ->set(ContentType::class)
            ->set(Location::class)
            ->set(Refresh::class)
            ->set(Status::class);
    }
}