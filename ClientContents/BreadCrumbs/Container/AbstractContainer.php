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
namespace GI\ClientContents\BreadCrumbs\Container;

use GI\ClientContents\BreadCrumbs\Node\Node;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\BreadCrumbs\Node\NodeInterface;

abstract class AbstractContainer implements ContainerInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var NodeInterface[]
     */
    private $nodes = [];


    /**
     * AbstractContainer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createContents();
    }

    /**
     * @param string $id
     * @param NodeInterface|null $parent
     * @return NodeInterface
     */
    protected function createNode(string $id, NodeInterface $parent = null)
    {
        try {
            $result = $this->giGetDi(NodeInterface::class, null, [$id, $parent]);
        } catch (\Exception $e) {
            $result = new Node($id, $parent);
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getContents()
    {
        return [];
    }

    /**
     * @param NodeInterface|null $parent
     * @param array|null $contents
     * @return static
     * @throws \Exception
     */
    protected function createContents(NodeInterface $parent = null, array $contents = null)
    {
        if (!is_array($contents)) {
            $contents = $this->getContents();
        }

        foreach ($contents as $key => $value) {
            if (is_int($key) && is_string($value)) {
                $node = $this->createNode($value, $parent);
                $this->set($node);
            } elseif (is_string($key) && is_array($value)) {
                $node = $this->createNode($key, $parent);
                $this->set($node);
                $this->createContents($node, $value);
            } else {
                $this->giThrowInvalidFormatException('Node', $key, 'string/array');
            }
        }

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return NodeInterface
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $key = $this->giGetPSRFormatParser()->parseWithPrefixGet($method);
        } catch (\Exception $exception) {
            $key = null;
            $this->giThrowMagicMethodException($method);
        }

        $key = $this->giGetCamelCaseConverter()->convertToHyphenLowerCase($key);

        return $this->get($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->nodes[$key]);
    }

    /**
     * @param string $key
     * @return NodeInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->nodes[$key];
    }

    /**
     * @return NodeInterface[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->nodes);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->nodes);
    }

    /**
     * @param NodeInterface $node
     * @return static
     */
    protected function set(NodeInterface $node)
    {
        $this->nodes[$node->getId()] = $node;

        return $this;
    }
}