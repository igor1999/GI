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

use GI\Storage\Collection\StringCollection\HashSet\Alterable\AlterableInterface as HashSetInterface;

interface XPathInterface
{
    /**
     * @return string
     */
    public function hasQuery();

    /**
     * @return string
     */
    public function getQuery();

    /**
     * @param string $query
     * @return static
     */
    public function setQuery(string $query);

    /**
     * @return HashSetInterface
     */
    public function getNamespaces();

    /**
     * @param \DOMElement $xmlDOM
     * @return \DOMNodeList
     * @throws \Exception
     */
    public function create(\DOMElement $xmlDOM);
}