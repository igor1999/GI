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
namespace GI\DOM\HTML\Element\Style;

use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\Style\Selector\SelectorList;

use GI\DOM\HTML\Element\Style\Selector\SelectorListInterface;
use GI\DOM\HTML\Element\Style\Selector\SelectorInterface;

class Style extends ContainerElement implements StyleInterface
{
    const TAG = 'style';


    /**
     * @var SelectorListInterface
     */
    private $childNodes;


    /**
     * Style constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createChildNodes()
    {
        $this->childNodes = $this->giGetDi(SelectorListInterface::class, SelectorList::class);

        return $this;
    }

    /**
     * @return SelectorListInterface
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

    /**
     * @param \Closure $filter
     * @return static
     */
    protected function find(\Closure $filter)
    {
        $nodes = array_filter($this->getChildNodes()->getItems(), $filter);

        $result = new static();
        foreach ($nodes as $selector) {
            $result->getChildNodes()->addSelector($selector);
        }

        return $result;
    }

    /**
     * @param string $attribute
     * @param bool|string $value
     * @param bool $withMe
     * @return static
     */
    public function findByAttribute(string $attribute, $value, bool $withMe = false)
    {
        $filter = function(SelectorInterface $node) use ($attribute, $value)
        {
            return $node->has($attribute) && ($node->get($attribute) == $value);
        };

        return $this->find($filter);
    }

    /**
     * @param string $selector
     * @return static
     */
    public function findBySelector(string $selector)
    {
        $filter = function(SelectorInterface $node) use ($selector)
        {
            return $node->getSelector() == $selector;
        };

        return $this->find($filter);
    }
}