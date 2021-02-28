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
namespace GI\Markup\Reader;

use GI\Markup\Reader\Base\AbstractCollection;

use GI\Util\TextProcessing\Encoding\EncodingTrait;
use GI\Util\TextProcessing\XML\Version\VersionTrait;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

abstract class AbstractReader extends AbstractCollection implements ReaderInterface
{
    use EncodingTrait, VersionTrait;


    /**
     * AbstractReader constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct($this);

        $this->initEncodingByContext()->initXMLVersionByContext();
    }

    /**
     * @param FSOFileInterface $file
     * @return array
     */
    public function readFile(FSOFileInterface $file)
    {
        $domDoc = $this->createDOMDocument();
        $domDoc->load($file->getPath());

        return $this->read($domDoc->documentElement);
    }

    /**
     * @param string $xml
     * @return array
     */
    public function readString(string $xml)
    {
        $domDoc = $this->createDOMDocument();
        $domDoc->loadXML($xml);

        return $this->read($domDoc->documentElement);
    }

    /**
     * @return \DOMDocument
     */
    public function createDOMDocument()
    {
        return new \DOMDocument($this->xmlVersion, $this->encoding);
    }

    /**
     * @param \DOMElement $domElement
     * @return array
     */
    protected function read(\DOMElement $domElement)
    {
        $result = [];

        foreach ($this->getItems() as $item) {
            $result = $this->mergeReadResults($result, $item->read($domElement));
        }

        return $result;
    }
}