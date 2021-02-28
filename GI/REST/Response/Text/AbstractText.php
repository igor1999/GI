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
namespace GI\REST\Response\Text;

use GI\REST\Response\AbstractResponse;

abstract class AbstractText extends AbstractResponse implements TextInterface
{
    /**
     * @var string
     */
    private $text = '';

    /**
     * @var string
     */
    private $contentType = '';


    /**
     * AbstractText constructor.
     * @param string $text
     * @param string $contentType
     */
    public function __construct(string $text, string $contentType)
    {
        $this->text        = $text;
        $this->contentType = $contentType;

        parent::__construct();
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
        echo $this->text;

        return $this;
    }
}