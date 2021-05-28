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
namespace GI\Markup\Reader\Base;

use GI\Markup\Reader\Branch\Branch;
use GI\Markup\Reader\Leaf\Leaf;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Markup\Reader\Branch\BranchInterface;
use GI\Markup\Reader\Leaf\LeafInterface;
use GI\Markup\Reader\ReaderInterface;
use GI\Markup\Reader\Base\Node\NodeInterface;

abstract class AbstractCollection implements CollectionInterface
{
    use ServiceLocatorAwareTrait, ReaderAwareTrait;


    const KEY_SEPARATOR = '_';


    /**
     * @var NodeInterface[]
     */
    private $items = [];


    /**
     * AbstractCollection constructor.
     * @param ReaderInterface $reader
     * @param array $contents
     * @throws \Exception
     */
    public function __construct(ReaderInterface $reader, array $contents = [])
    {
        $this->reader = $reader;

        if (empty($contents)) {
            $contents = $this->getContents();
        }

        $this->createContents($contents);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @return NodeInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->getGiServiceLocator()->throwNotInScopeException($key);
        }

        return $this->items[$key];
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
     * @param string $key
     * @param NodeInterface $item
     * @return static
     */
    public function set(string $key, NodeInterface $item)
    {
        $this->items[$key] = $item;

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key)
    {
        if ($result = $this->has($key)) {
            unset($this->items[$key]);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @return array
     */
    abstract protected function getContents();

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    protected function createContents(array $contents)
    {
        foreach ($contents as $key => $value) {
            if (is_int($key) && is_string($value)) {
                $item = $this->getGiServiceLocator()->getDependency(LeafInterface::class, Leaf::class, [$this->getReader()]);
                $this->set($value, $item);
            } elseif (is_string($key) && is_array($value)) {
                $item = $this->getGiServiceLocator()->getDependency(
                    BranchInterface::class, Branch::class, [$this->getReader(), $value]
                );
                $this->set($key, $item);
            } elseif (is_string($key) && is_a($value, BranchInterface::class, true)) {
                $this->set($key, new $value($this->getReader()));
            } elseif (is_string($key) && is_a($value, LeafInterface::class, true)) {
                $this->set($key, new $value($this->getReader()));
            } elseif (is_string($key) && is_a($value, BranchInterface::class)) {
                $this->set($key, $value);
            } elseif (is_string($key) && is_a($value, LeafInterface::class)) {
                $this->set($key, $value);
            } else {
                $this->getGiServiceLocator()->throwInvalidFormatException('Item', $key, 'XML reader branch or leaf');
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
            $keys = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixGet($method);
        } catch (\Exception $exception) {
            $keys = null;
            $this->getGiServiceLocator()->throwMagicMethodException($method);
        }

        $keys = array_filter(explode(static::KEY_SEPARATOR, $keys));

        $f = function($key)
        {
            return $this->getGiServiceLocator()->getUtilites()->getCamelCaseConverter()->convertToHyphenLowerCase($key);
        };
        $keys = array_map($f, $keys);

        return $this->findNodeRecursive($keys);
    }

    /**
     * @param array $keys
     * @return NodeInterface
     * @throws \Exception
     */
    public function findNodeRecursive(array $keys)
    {
        if (empty($keys)) {
            $this->getGiServiceLocator()->throwIsEmptyException('Keys for recursive search');
        }

        $localKey = array_shift($keys);

        $result = $this->get($localKey);

        if (!empty($keys)) {
            if ($result instanceof BranchInterface) {
                $result = $result->findNodeRecursive($keys);
            } else {
                $this->getGiServiceLocator()->throwNotFoundException('Node in recursive search');
            }
        }

        return $result;
    }

    /**
     * @param array $old
     * @param array $new
     * @return array
     */
    protected function mergeReadResults(array $old, array $new)
    {
        return array_merge($old, $new);
    }
}