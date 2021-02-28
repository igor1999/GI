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
namespace GI\DOM\HTML\Element\Document\Head;

use GI\DOM\HTML\Element\ContainerElement;

use GI\DOM\HTML\Element\Document\Meta\Charset\CharsetInterface;
use GI\DOM\HTML\Element\Script\Extern\ExternInterface;
use GI\DOM\HTML\Element\Link\Named\CSS\CSSInterface;
use GI\DOM\HTML\Element\Document\Title\TitleInterface;

class Head extends ContainerElement implements HeadInterface
{
    const TAG = 'head';


    /**
     * @var CharsetInterface
     */
    private $charset;

    /**
     * @var TitleInterface
     */
    private $title;


    /**
     * Head constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);

        $this->setCharset();

        $this->title = $this->giGetDOMFactory()->createTitle();
    }

    /**
     * @return CharsetInterface
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param string $charset
     * @return static
     */
    public function setCharset(string $charset = CharsetInterface::DEFAULT_CHARSET)
    {
        $this->charset = $this->giGetDOMFactory()->createCharset($charset);

        return $this;
    }

    /**
     * @return TitleInterface
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $text
     * @return static
     */
    public function setTitle(string $text = '')
    {
        $this->getTitle()->getChildNodes()->set($text);

        return $this;
    }

    /**
     * @param string $href
     * @return static
     */
    public function addCSS(string $href)
    {
        $this->getChildNodes()->add($this->createCSS($href));

        return $this;
    }

    /**
     * @param string $href
     * @return CSSInterface
     */
    protected function createCSS(string $href)
    {
        return $this->giGetDOMFactory()->createCSS($href);
    }

    /**
     * @param string $src
     * @return static
     */
    public function addExternScript(string $src)
    {
        $this->getChildNodes()->add($this->createExtern($src));

        return $this;
    }

    /**
     * @param string $src
     * @return ExternInterface
     */
    protected function createExtern(string $src)
    {
        return $this->giGetDOMFactory()->createExternScript($src);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function compileInnerHTML()
    {
        return $this->getCharset()->toString() . PHP_EOL
            . $this->getTitle()->toString() . PHP_EOL
            . parent::compileInnerHTML();
    }
}