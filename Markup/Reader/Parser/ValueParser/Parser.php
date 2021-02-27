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
namespace GI\Markup\Reader\Parser\ValueParser;

use GI\Markup\Reader\Parser\AbstractParser;
use GI\Markup\Reader\ReaderInterface;

class Parser extends AbstractParser implements ParserInterface
{
    /**
     * Parser constructor.
     * @param ReaderInterface $reader
     */
    public function __construct(ReaderInterface $reader)
    {
        parent::__construct($reader);

        $this->setToText();
    }

    /**
     * @return bool
     */
    public function isModeText()
    {
        return $this->getMode() == self::MODE_TEXT;
    }

    /**
     * @return static
     */
    public function setToText()
    {
        $this->setMode(self::MODE_TEXT);

        return $this;
    }

    /**
     * @param int $index
     * @param \DOMElement $node
     * @return string
     * @throws \Exception
     */
    public function parse(int $index, \DOMElement $node)
    {
        switch (true) {
            case $this->isModeText():
                $result = trim($node->nodeValue);
                $result = $this->getEscaper()->unescape($result);
                break;
            default:
                $result = parent::parse($index, $node);
                break;
        }

        return $result;
    }
}