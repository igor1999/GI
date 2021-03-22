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
namespace GI\RDB\ORM\Set\Index;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\ORM\Record\RecordInterface;
use GI\RDB\ORM\Set\SetInterface;

abstract class AbstractIndex implements IndexInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var RecordInterface[]
     */
    private $items = [];

    /**
     * @var SetInterface
     */
    private $source;


    /**
     * AbstractIndex constructor.
     * @param SetInterface $source
     */
    public function __construct(SetInterface $source)
    {
        $this->source = $source;

        $this->refresh();
    }

    /**
     * @return SetInterface
     */
    protected function getSource()
    {
        return $this->source;
    }

    /**
     * @param int $index
     * @return string
     */
    abstract protected function createKey(int $index);

    /**
     * @param array $keys
     * @return string
     * @throws \Exception
     */
    protected function arrayToKey(array $keys)
    {
        if (empty($keys)) {
            $this->giThrowIsEmptyException('Keys');
        }

        return array_shift($keys);
    }

    /**
     * @param string|array $key
     * @return bool
     * @throws \Exception
     */
    public function has($key)
    {
        if (is_array($key)) {
            $key = $this->arrayToKey($key);
        }

        return isset($this->items[$key]);
    }

    /**
     * @param string|array $key
     * @return RecordInterface
     * @throws \Exception
     */
    public function get($key)
    {
        if (is_array($key)) {
            $key = $this->arrayToKey($key);
        }

        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @return RecordInterface[]
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
     * @return int
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @return static
     */
    protected function clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @return static
     */
    public function refresh()
    {
        $this->clean();

        foreach ($this->getSource()->getItems() as $index => $record) {
            $this->items[$this->createKey($index)] = $record;
        }

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return RecordInterface
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $key = $this->giGetPSRFormatParser()->parseWithPrefixGet($method, '', false);
        } catch (\Exception $exception) {
            $key = null;
            $this->giThrowMagicMethodException($method);
        }

        return $this->get($key);
    }
}