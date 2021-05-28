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
namespace GI\Markup\Reader\Leaf;

use GI\Markup\Reader\Parser\ValueParser\Parser as ValueParser;

use GI\Markup\Reader\Base\ReaderAwareTrait;
use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Markup\Reader\Base\Node\NodeTrait;

use GI\Markup\Reader\ReaderInterface;
use GI\Markup\Reader\Parser\ValueParser\ParserInterface as ValueParserInterface;

class Leaf implements LeafInterface
{
    use ServiceLocatorAwareTrait, NodeTrait, ReaderAwareTrait;


    /**
     * @var ValueParserInterface
     */
    private $valueParser;


    /**
     * Leaf constructor.
     * @param ReaderInterface $reader
     */
    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @return ValueParserInterface|mixed
     * @throws \Exception
     */
    public function getValueParser()
    {
        if (!($this->valueParser instanceof ValueParserInterface)) {
            $this->valueParser = $this->getGiServiceLocator()->getDependency(
                ValueParserInterface::class, ValueParser::class, [$this->getReader()]
            );
        }

        return $this->valueParser;
    }

    /**
     * @param \DOMElement $domElement
     * @return array
     * @throws \Exception
     */
    public function read(\DOMElement $domElement)
    {
        $result = [];

        $nodes = $this->getXPath()->create($domElement);

        /** @var \DOMElement $node */
        foreach ($nodes as $index => $node) {
            $key   = $this->getKeyParser()->parse($index, $node);
            $value = $this->getValueParser()->parse($index, $node);

            if (!array_key_exists($key, $result)) {
                $result[$key] = $value;
            } elseif (!is_array($result[$key])) {
                $result[$key] = [$result[$key], $value];
            } else {
                $result[$key][] = $value;
            }
        }

        return $result;
    }
}