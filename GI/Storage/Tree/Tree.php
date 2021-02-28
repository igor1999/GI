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
namespace GI\Storage\Tree;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Closing\ClosingTrait;

class Tree implements TreeInterface
{
    use ServiceLocatorAwareTrait, ClosingTrait;


    const KEY_SEPARATOR = '/';


    /**
     * @var array
     */
    private $nodes = [];


    /**
     * Tree constructor.
     * @param array $nodes
     * @throws \Exception
     */
    public function __construct(array $nodes = [])
    {
        $this->hydrate($nodes);
    }

    /**
     * @param array|string|int $key
     * @return array
     * @throws \Exception
     */
    protected function getKeyAsArray($key)
    {
        if (!is_array($key)) {
            $key = [$key];
        }

        if (empty($key)) {
            $this->giThrowIsEmptyException('Keys array');
        }

        return $key;
    }

    /**
     * @param array $keys
     * @return TreeInterface
     * @throws \Exception
     */
    public function findNodeRecursive(array $keys)
    {
        if (empty($keys)) {
            $result = $this;
        } else {
            $localKey = array_shift($keys);

            $node = $this->getLocally($localKey);

            if (!($node instanceof TreeInterface)) {
                $this->giThrowNotInScopeException(implode(static::KEY_SEPARATOR, $keys));
            }

            $result = $node->findNodeRecursive($keys);
        }

        return $result;
    }

    /**
     * @param string|int $key
     * @return bool
     */
    public function hasLocally($key)
    {
        return array_key_exists($key, $this->nodes);
    }

    /**
     * @param string|int|array $key
     * @return bool
     * @throws \Exception
     */
    public function has($key)
    {
        $keys = $this->getKeyAsArray($key);

        $localKey = array_pop($keys);

        try {
            $result = $this->findNodeRecursive($keys)->hasLocally($localKey);
        } catch (\Exception $exception) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param string|int $key
     * @return mixed
     * @throws \Exception
     */
    public function getLocally($key)
    {
        if (!$this->hasLocally($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->nodes[$key];
    }

    /**
     * @param string|int|array $key
     * @return mixed
     * @throws \Exception
     */
    public function get($key)
    {
        $keys = $this->getKeyAsArray($key);

        $localKey = array_pop($keys);

        return $this->findNodeRecursive($keys)->getLocally($localKey);
    }

    /**
     * @param string|int|array $key
     * @param mixed|null $defaultValue
     * @return mixed
     */
    public function getOptional($key, $defaultValue = null)
    {
        try {
            $result = $this->get($key);
        } catch (\Exception $exception) {
            $result = $defaultValue;
        }

        return $result;
    }

    /**
     * @return array
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
     * @param mixed $element
     * @return array|false
     */
    public function findKey($element)
    {
        $keys = array_search($element, $this->nodes);

        if ($keys === false) {
            foreach ($this->nodes as $key => $node) {
                if ($node instanceof TreeInterface) {
                    $keys = $node->findKey($element);
                    if ($keys !== false) {
                        array_unshift($keys, $key);
                        break;
                    }
                }
            }
        } else {
            $keys = [$keys];
        }

        return $keys;
    }

    /**
     * @param mixed $element
     * @return bool
     */
    public function contains($element)
    {
        return $this->findKey($element) !== false;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function extract()
    {
        $result = [];

        $nodeClass = get_class($this->createNode());

        foreach ($this->nodes as $key => $node) {
            if ($node instanceof TreeInterface) {
                $result[$key] = is_a($node, $nodeClass) ? $node->extract() : $node;
            } else {
                $result[$key] = $node;
            }
        }

        return $result;
    }

    /**
     * @param string|int|array $key
     * @param mixed $newNode
     * @return static
     * @throws \Exception
     */
    public function set($key, $newNode)
    {
        $this->validateClosing();

        $keys = $this->getKeyAsArray($key);

        $localKey = array_shift($keys);

        if (empty($keys)) {
            $this->nodes[$localKey] = is_array($newNode) ? $this->createNode($newNode) : $newNode;
        } else {
            /** @var TreeInterface $medium */
            $medium = $this->createNode();
            $medium->set($keys, $newNode);

            $this->nodes[$localKey] = $medium;
        }

        return $this;
    }

    /**
     * @param array $nodes
     * @return static
     * @throws \Exception
     */
    protected function createNode(array $nodes = [])
    {
        return new static($nodes);
    }

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function apply(array $contents)
    {
        foreach ($contents as $key => $node) {
            $this->set($key, $node);
        }

        return $this;
    }

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $contents)
    {
        $this->clean()->apply($contents);

        return $this;
    }

    /**
     * @param string|int|array $key
     * @return bool
     * @throws \Exception
     */
    public function remove($key)
    {
        $this->validateClosing();

        $result = $this->has($key);

        if ($result) {
            $keys = $this->getKeyAsArray($key);

            $localKey = array_pop($keys);

            if (empty($keys)) {
                unset($this->nodes[$localKey]);
            } else {
                /** @var TreeInterface $medium */
                $medium = $this->get($keys);
                $medium->remove($localKey);
            }
        }

        return $result;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function clean()
    {
        $this->validateClosing();

        $this->nodes = [];

        return $this;
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->setClosed(true);

        foreach ($this->nodes as $node) {
            if ($node instanceof TreeInterface) {
                $node->close();
            }
        }

        return $this;
    }
}