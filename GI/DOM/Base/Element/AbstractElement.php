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
namespace GI\DOM\Base\Element;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

abstract class AbstractElement implements ElementInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $tag = '';


    /**
     * AbstractElement constructor.
     *
     * @param string $tag
     */
    public function __construct(string $tag = '')
    {
        $this->tag = $tag;
    }

    /**
     * @return bool
     */
    public function hasTag()
    {
        return !empty($this->tag);
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    abstract protected function getTagTemplate();

    /**
     * @return string
     */
    abstract protected function getContents();

    /**
     * @return string
     */
    protected function getEndTagTemplate()
    {
        return '</%s>';
    }

    /**
     * @return string
     */
    protected function buildTag()
    {
        return sprintf($this->getTagTemplate(), $this->getTag(), $this->getContents());
    }

    /**
     * @return string
     */
    protected function buildEndTag()
    {
        return sprintf($this->getEndTagTemplate(), $this->getTag());
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->buildTag() . PHP_EOL;
    }
}