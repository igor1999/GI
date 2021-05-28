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
namespace GI\DOM\HTML\Element\Document;

use GI\DOM\HTML\Element\ContainerElement;

use GI\DOM\HTML\Element\Document\Doctype\DoctypeInterface;
use GI\DOM\HTML\Element\Document\Head\HeadInterface;
use GI\DOM\HTML\Element\Document\Body\BodyInterface;

class Document extends ContainerElement implements DocumentInterface
{
    const TAG = 'html';


    /**
     * @var DoctypeInterface
     */
    private $doctype;

    /**
     * @var HeadInterface
     */
    private $head;

    /**
     * @var BodyInterface
     */
    private $body;


    /**
     * Document constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);

        $this->doctype = $this->getGiServiceLocator()->getDOMFactory()->createDoctype();
        $this->head    = $this->getGiServiceLocator()->getDOMFactory()->createHead();
        $this->body    = $this->getGiServiceLocator()->getDOMFactory()->createBody();
    }

    /**
     * @return DoctypeInterface
     */
    public function getDoctype()
    {
        return $this->doctype;
    }

    /**
     * @param string $doctype
     * @return static
     */
    public function setDoctype(string $doctype)
    {
        $this->getDoctype()->setContents($doctype);

        return $this;
    }

    /**
     * @return HeadInterface
     */
    public function getHead()
    {
         return $this->head;
    }

    /**
     * @return BodyInterface
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $contents = [
            $this->getDoctype()->toString(),
            $this->buildTag(),
            $this->getHead()->toString(),
            $this->getBody()->toString(),
            $this->buildEndTag(),
        ];

        return implode(PHP_EOL, $contents);
    }
}