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

use GI\DOM\HTML\Element\Document\Meta\Charset\CharsetInterface;
use GI\DOM\HTML\Element\ContainerElementInterface;
use GI\DOM\HTML\Element\Document\Title\TitleInterface;

interface HeadInterface extends ContainerElementInterface
{
    /**
     * @return CharsetInterface
     */
    public function getCharset();

    /**
     * @param string $charset
     * @return static
     */
    public function setCharset(string $charset = CharsetInterface::DEFAULT_CHARSET);

    /**
     * @return TitleInterface
     */
    public function getTitle();

    /**
     * @param string $text
     * @return static
     */
    public function setTitle(string $text = '');

    /**
     * @param string $href
     * @return static
     */
    public function addCSS(string $href);

    /**
     * @param string $src
     * @return static
     */
    public function addExternScript(string $src);
}