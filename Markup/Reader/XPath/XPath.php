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
namespace GI\Markup\Reader\XPath;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Markup\Reader\Base\ReaderAwareTrait;

use GI\Markup\Reader\ReaderInterface;
use GI\Storage\Collection\StringCollection\HashSet\Alterable\AlterableInterface as HashSetInterface;

class XPath implements XPathInterface
{
    use ServiceLocatorAwareTrait, ReaderAwareTrait;


    /**
     * @var string
     */
    private $query = '';

    /**
     * @var HashSetInterface
     */
    private $namespaces;


    /**
     * XPath constructor.
     * @param ReaderInterface $reader
     * @throws \Exception
     */
    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;

        $this->namespaces = $this->giGetStorageFactory()->createStringHashSetAlterable();
    }

    /**
     * @return string
     */
    public function hasQuery()
    {
        return !empty($this->query);
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return static
     */
    public function setQuery(string $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return HashSetInterface
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * @param \DOMElement $xmlDOM
     * @return \DOMNodeList
     * @throws \Exception
     */
    public function create(\DOMElement $xmlDOM)
    {
        $simpleXML = simplexml_import_dom($xmlDOM);

        $domDoc = $this->getReader()->createDOMDocument();
        $domDoc->loadXML($simpleXML->asXML());

        $xpath = new \DOMXPath($domDoc);

        foreach ($this->getNamespaces()->getItems() as $prefix => $uri) {
            $xpath->registerNamespace($prefix, $uri);
        }

        $nodes = $xpath->query($this->query);

        if (!($nodes instanceof \DOMNodeList)) {
            $this->giThrowInvalidFormatException('XPath Query', $this->query, 'valid XPath query');
        }

        return  $nodes;
    }
}