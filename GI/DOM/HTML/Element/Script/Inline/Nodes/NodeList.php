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
namespace GI\DOM\HTML\Element\Script\Inline\Nodes;

use GI\DOM\Base\ChildNodesCollection\AbstractImmutable;
use GI\DOM\Base\NodeInterface;

class NodeList extends AbstractImmutable implements NodeListInterface
{
    /**
     * @param int $index
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        /** @var ScriptNodeInterface $child */
        $child = parent::get($index);

        return $child;
    }

    /**
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        /** @var ScriptNodeInterface $child */
        $child = parent::getFirst();

        return $child;
    }

    /**
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function getLast()
    {
        /** @var ScriptNodeInterface $child */
        $child = parent::getLast();

        return $child;
    }

    /**
     * @param NodeInterface $item
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item)
    {
        /** @var ScriptNodeInterface $previous */
        $previous = parent::getPrevious($item);

        return $previous;
    }

    /**
     * @param NodeInterface $item
     * @return ScriptNodeInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item)
    {
        /** @var ScriptNodeInterface $next */
        $next = parent::getNext($item);

        return $next;
    }

    /**
     * @return ScriptNodeInterface[]
     */
    public function getItems()
    {
        /** @var ScriptNodeInterface[] $children */
        $children = parent::getItems();

        return $children;
    }

    /**
     * @param string $node
     * @return static
     */
    public function setScript(string $node)
    {
        $this->set($this->createNode($node));

        return $this;
    }

    /**
     * @param string $file
     * @return static
     */
    public function loadScript(string $file)
    {
        $this->setScript(file_get_contents($file));

        return $this;
    }

    /**
     * @param string $node
     * @return static
     */
    public function addNode(string $node)
    {
        $this->add($this->createNode($node));

        return $this;
    }

    /**
     * @param string $file
     * @return static
     */
    public function loadAndAddNode(string $file)
    {
        $this->addNode(file_get_contents($file));

        return $this;
    }

    /**
     * @param int $index
     * @param string $node
     * @return static
     */
    public function insertNode(int $index, string $node)
    {
        $this->insert($index, $this->createNode($node));

        return $this;
    }

    /**
     * @param int $index
     * @param string $file
     * @return static
     */
    public function loadAndInsertNode(int $index, string $file)
    {
        $this->insertNode($index, file_get_contents($file));

        return $this;
    }

    /**
     * @param string $node
     * @return ScriptNodeInterface
     */
    protected function createNode(string $node)
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(NodeInterface::class, null, [$node]);
        } catch (\Exception $e) {
            $result = new ScriptNode($node);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        parent::clean();

        return $this;
    }
}