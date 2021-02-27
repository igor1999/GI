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
namespace GI\Markup\Reader\Base\Node;

use GI\Markup\Reader\XPath\XPath;
use GI\Markup\Reader\Parser\KeyParser\Parser as KeyParser;

use GI\Markup\Reader\XPath\XPathInterface;
use GI\Markup\Reader\Parser\KeyParser\ParserInterface as KeyParserInterface;

trait NodeTrait
{
    /**
     * @var XPathInterface
     */
    private $xPath;

    /**
     * @var KeyParserInterface
     */
    private $keyParser;


    /**
     * @return XPathInterface
     */
    public function getXPath()
    {
        if (!($this->xPath instanceof XPathInterface)) {
            $this->xPath = $this->giGetDi(
                XPathInterface::class, XPath::class, [$this->getReader()]
            );
        }

        return $this->xPath;
    }

    /**
     * @return KeyParserInterface
     */
    public function getKeyParser()
    {
        if (!($this->keyParser instanceof KeyParserInterface)) {
            $this->keyParser = $this->giGetDi(
                KeyParserInterface::class, KeyParser::class, [$this->getReader()]
            );
        }

        return $this->keyParser;
    }
}