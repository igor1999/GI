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
namespace GI\REST\Response\FileResponse;

use GI\REST\Response\AbstractResponse;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

abstract class AbstractFileResponse extends AbstractResponse implements FileResponseInterface
{
    /**
     * @var FSOFileInterface
     */
    private $file;

    /**
     * @var string
     */
    private $contentType = '';


    /**
     * AbstractFileResponse constructor.
     * @param FSOFileInterface $file
     * @param string $contentType
     */
    public function __construct(FSOFileInterface $file, string $contentType)
    {
        $this->file        = $file;
        $this->contentType = $contentType;

        parent::__construct();
    }

    /**
     * @return FSOFileInterface
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return static
     */
    protected function setRequiredHeaders()
    {
        $this->getHeaders()->addContentType($this->contentType);

        return $this;
    }

    /**
     * @return static
     */
    public function dispatchBody()
    {
        readfile($this->getFile()->getPath());

        return $this;
    }
}