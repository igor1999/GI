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

use GI\DOM\Base\ChildNodesCollection\Alterable;

use GI\DOM\Base\ChildNodesCollection\AlterableInterface;

abstract class AbstractContainerElement extends AbstractAttributedElement implements ContainerElementInterface
{
    /**
     * @var AlterableInterface
     */
    private $childNodes;


    /**
     * AbstractContainerElement constructor.
     * @param string $tag
     * @throws \Exception
     */
    public function __construct(string $tag = '')
    {
        parent::__construct($tag);

        $this->createChildNodes();
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createChildNodes()
    {
        $this->childNodes = $this->giGetDi(AlterableInterface::class, Alterable::class);

        return $this;
    }

    /**
     * @return AlterableInterface
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

    /**
     * @return string
     */
    protected function getTagTemplate()
    {
        return '<%s %s>';
    }

    /**
     * @return string
     */
    public function toString()
    {
        if ($this->hasTag()) {
            $output = $this->buildTag() . PHP_EOL .
                $this->compileInnerHTML() . PHP_EOL .
                $this->buildEndTag() . PHP_EOL;
        } else {
            $output = $this->compileInnerHTML() . PHP_EOL;
        }

        return $output;
    }

    /**
     * @return string
     */
    protected function compileInnerHTML()
    {
        return $this->getChildNodes()->toString();
    }
}