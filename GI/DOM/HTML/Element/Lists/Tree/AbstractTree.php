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
namespace GI\DOM\HTML\Element\Lists\Tree;

use GI\DOM\HTML\Element\Lists\UL\UL;

use GI\DOM\Base\NodeInterface;

abstract class AbstractTree extends UL implements TreeInterface
{
    const KEY_SEPARATOR = ' ';


    const TREE_ATTRIBUTE = 'tree';

    const NODE_ATTRIBUTE = 'node';


    /**
     * @var array
     */
    private $source;

    /**
     * @var string
     */
    private $parentKey = '';


    /**
     * AbstractTree constructor.
     * @param array $source
     * @param string $parentKey
     * @throws \Exception
     */
    public function __construct(array $source, string $parentKey = '')
    {
        parent::__construct();

        $this->source    = $source;
        $this->parentKey = $parentKey;

        $this->getAttributes()->setDataAttribute(static::TREE_ATTRIBUTE, $this->parentKey);

        $this->create();
    }

    /**
     * @return array
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getParentKey()
    {
        return $this->parentKey;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function create()
    {
        foreach ($this->getSource() as $key => $node) {

            $parentKey = empty($this->parentKey) ? $key : $this->parentKey . static::KEY_SEPARATOR . $key;

            $context  = $this->getContext($node);
            $children = $this->getChildren($node);

            $li = $this->giGetDOMFactory()->createLI($context);

            if (!empty($children)) {
                $childrenContainer = new static($children, $parentKey);
                $li->getChildNodes()->add($childrenContainer);
            }

            $li->getAttributes()->setDataAttribute(static::NODE_ATTRIBUTE, $key);
            $this->getChildNodes()->addItem($li);
        }

        return $this;
    }

    /**
     * @param mixed $node
     * @return NodeInterface|string
     */
    abstract protected function getContext($node);

    /**
     * @param mixed $node
     * @return array
     */
    abstract protected function getChildren($node);
}