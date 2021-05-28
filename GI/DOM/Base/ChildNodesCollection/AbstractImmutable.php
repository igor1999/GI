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
namespace GI\DOM\Base\ChildNodesCollection;

use GI\DOM\Base\TextNode\TextNode;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\DOM\Base\NodeInterface;
use GI\DOM\Base\TextNode\TextNodeInterface;

abstract class AbstractImmutable implements ImmutableInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var NodeInterface[]
     */
    private $items = [];


    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return array_key_exists($index, $this->items);
    }

    /**
     * @param int $index
     * @return NodeInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->getGiServiceLocator()->throwNotInScopeException($index);
        }

        return $this->items[$index];
    }

    /**
     * @return NodeInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        return $this->get(0);
    }

    /**
     * @return NodeInterface
     * @throws \Exception
     */
    public function getLast()
    {
        return $this->get($this->getLength() - 1);
    }

    /**
     * @param NodeInterface $item
     * @return NodeInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        $index = $this->find($item);

        return ($index === false) ? $this->get(-1) : $this->get($index - 1);
    }

    /**
     * @param NodeInterface $item
     * @return NodeInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        $index = $this->find($item);

        return ($index === false) ? $this->get(-1) : $this->get($index + 1);
    }

    /**
     * @return NodeInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param NodeInterface $child
     * @return int|false
*/
    public function find(NodeInterface $child)
    {
        return array_search($child, $this->items);
    }

    /**
     * @param NodeInterface $child
     * @return bool
     */
    public function hasItem(NodeInterface $child)
    {
        return $this->find($child) !== false;
    }

    /**
     * @param string|array|NodeInterface $contents
     * @return array
     */
    protected function prepare($contents)
    {
        /** @var array $contents */
        $contents = is_array($contents)
            ? $this->getGiServiceLocator()->getUtilites()->getFlatCreator()->create($contents)
            : [$contents];

        $f = function($child)
        {
            return !is_scalar($child) ? $child : $this->prepareScalar($child);
        };
        $contents = array_map($f, $contents);

        $f = function($child)
        {
            return $this->filter($child);
        };
        $contents = array_filter($contents, $f);

        return $contents;
    }

    /**
     * @param mixed $node
     * @return TextNodeInterface
     */
    protected function prepareScalar($node)
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(TextNodeInterface::class, TextNode::class, [$node]);
        } catch (\Exception $e) {
            $result = new TextNode($node);
        }

        return $result;
    }

    /**
     * @param mixed $node
     * @return bool
     */
    protected function filter($node)
    {
        return $node instanceof NodeInterface;
    }

    /**
     * @param string|array|NodeInterface $contents
     * @return static
     */
    protected function set($contents)
    {
        $this->items = $this->prepare($contents);

        return $this;
    }

    /**
     * @param string|array|NodeInterface $contents
     * @return static
     */
    protected function add($contents)
    {
        $this->items = array_merge($this->items, $this->prepare($contents));

        return $this;
    }

    /**
     * @param int $index
     * @param string|array|NodeInterface $contents
     * @return static
     */
    protected function insert(int $index, $contents)
    {
        array_splice($this->items, $index, 0, $this->prepare($contents));

        return $this;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index)
    {
        $result = $this->has($index);

        if ($result) {
            array_splice($this->items, $index, 1);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->set([]);

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $f = function(NodeInterface $item)
        {
             return $item->toString();
        };

        return empty($this->items) ? '' : implode(PHP_EOL, array_map($f, $this->items));
    }
}