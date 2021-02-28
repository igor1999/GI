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

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Markup\Reader\Base\ReaderAwareTrait;

use GI\Util\TextProcessing\Escaper\HTMLText\EscaperInterface;
use GI\Markup\Reader\ReaderInterface;

class AbstractParser implements ParserInterface
{
    use ServiceLocatorAwareTrait, ReaderAwareTrait;


    /**
     * @var EscaperInterface
     */
    private $escaper;

    /**
     * @var string
     */
    private $mode = '';

    /**
     * @var string|\Closure
     */
    private $value = '';


    /**
     * AbstractParser constructor.
     * @param ReaderInterface $reader
     */
    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;

        $this->escaper = $this->giGetUtilites()->getEscaperFactory()->createHTMLText();
    }

    /**
     * @return EscaperInterface
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @return string
     */
    protected function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return static
     */
    protected function setMode(string $mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return \Closure|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param \Closure|string $value
     * @return static
     */
    protected function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isModeConst()
    {
        return $this->mode == self::MODE_CONST;
    }

    /**
     * @param string $value
     * @return static
     */
    public function setToConst(string $value)
    {
        $this->setMode(self::MODE_CONST)->setValue($value);

        return $this;
    }

    /**
     * @return bool
     */
    public function isModeAttribute()
    {
        return $this->mode == self::MODE_ATTRIBUTE;
    }

    /**
     * @param string $value
     * @return static
     */
    public function setToAttribute(string $value)
    {
        $this->setMode(self::MODE_ATTRIBUTE)->setValue($value);

        return $this;
    }

    /**
     * @return bool
     */
    public function isModeClosure()
    {
        return $this->mode == self::MODE_CLOSURE;
    }

    /**
     * @param \Closure $value
     * @return static
     */
    public function setToClosure(\Closure $value)
    {
        $this->setMode(self::MODE_CLOSURE)->setValue($value);

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
        $this->getEscaper()->setEncoding($this->getReader()->getEncoding());

        switch (true) {
            case $this->isModeConst():
                $result = $this->value;
                break;
            case $this->isModeAttribute():
                $result = $node->getAttribute($this->value);
                $result = $this->getEscaper()->unescape($result);
                break;
            case $this->isModeClosure():
                $result = call_user_func($this->value, $node, $index);
                break;
            default:
                $result = null;
                $this->giThrowNotFoundException('Parse mode');
        }

        return $result;
    }
}