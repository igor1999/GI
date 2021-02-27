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
use GI\Pattern\StringConvertable\StringConvertableInterface;
use GI\Storage\Tree\TreeInterface as SourceTreeInterface;

class Tree extends UL implements TreeInterface
{
    const KEY_SEPARATOR = ' ';


    const TREE_ATTRIBUTE = 'tree';

    const NODE_ATTRIBUTE = 'node';


    /**
     * @var SourceTreeInterface
     */
    private $source;

    /**
     * @var string
     */
    private $parentKey = '';


    /**
     * Tree constructor.
     * @param SourceTreeInterface $source
     * @param string $parentKey
     * @throws \Exception
     */
    public function __construct(SourceTreeInterface $source, string $parentKey = '')
    {
        parent::__construct();

        $this->source    = $source;
        $this->parentKey = $parentKey;

        $this->getAttributes()->setDataAttribute(static::TREE_ATTRIBUTE, $this->parentKey);

        $this->create();
    }

    /**
     * @return SourceTreeInterface
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
        foreach ($this->getSource()->getNodes() as $key => $node) {

            $parentKey = empty($this->parentKey) ? $key : $this->parentKey . static::KEY_SEPARATOR . $key;

            if ($node instanceof SourceTreeInterface) {
                $context = new static($node, $parentKey);
            } elseif ($node instanceof NodeInterface) {
                $context = $node;
            } elseif ($node instanceof StringConvertableInterface) {
                $context = $node->toString();
            } elseif (is_object($node)) {
                $context = null;
                $this->giThrowInvalidTypeException('Node', $parentKey, 'scalar or string convertable');
            } else {
                $context = $node;
            }

            $li = $this->giGetDOMFactory()->createLI($context);
            $li->getAttributes()->setDataAttribute(static::NODE_ATTRIBUTE, $key);

            $this->getChildNodes()->addItem($li);
        }

        return $this;
    }
}