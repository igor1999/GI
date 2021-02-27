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
namespace GI\Markup\Reader\Parser;

use GI\Util\TextProcessing\Escaper\HTMLText\EscaperInterface;

interface ParserInterface 
{
    const MODE_CONST     = 'const';

    const MODE_ATTRIBUTE = 'attribute';

    const MODE_CLOSURE   = 'closure';


    /**
     * @return EscaperInterface
     */
    public function getEscaper();

    /**
     * @return \Closure|string
     */
    public function getValue();

    /**
     * @return bool
     */
    public function isModeConst();

    /**
     * @param string $value
     * @return static
     */
    public function setToConst(string $value);

    /**
     * @return bool
     */
    public function isModeAttribute();

    /**
     * @param string $value
     * @return static
     */
    public function setToAttribute(string $value);

    /**
     * @return bool
     */
    public function isModeClosure();

    /**
     * @param \Closure $value
     * @return static
     */
    public function setToClosure(\Closure $value);

    /**
     * @param int $index
     * @param \DOMElement $node
     * @return string
     * @throws \Exception
     */
    public function parse(int $index, \DOMElement $node);
}