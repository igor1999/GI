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
namespace GI\Filter\Container;

use GI\Filter\AbstractFilter;

use GI\Filter\FilterInterface;

abstract class AbstractContainer extends AbstractFilter implements ContainerInterface
{
    const KEY_SEPARATOR = '_';


    /**
     * AbstractContainer constructor.
     * @param array $contents
     * @throws \Exception
     */
    public function __construct(array $contents = [])
    {
        if (empty($contents)) {
            $contents = $this->getContents();
        }

        $this->createContents($contents);
    }

    /**
     * @return array
     */
    protected function getContents()
    {
        return [];
    }

    /**
     * @param string|int $key
     * @return FilterInterface
     * @throws \Exception
     */
    abstract protected function _get($key);

    /**
     * @param string|int $key
     * @param FilterInterface $filter
     * @return static
     */
    abstract protected function _set($key, FilterInterface $filter);

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    protected function createContents(array $contents)
    {
        foreach ($contents as $key => $value) {
            if (is_object($value) && ($value instanceof FilterInterface)) {
                $filter = $value;
            } elseif (is_array($value) && $this->giGetAssocProcessor()->isAssoc($value)) {
                $filter =$this->giGetFilterFactory()->createRecursive($value);
            } elseif (is_array($value)) {
                $filter =$this->giGetFilterFactory()->createChain($value);
            } else {
                $filter = null;
                $this->giThrowInvalidFormatException('Filter format with key', $key, 'filter contents');
            }

            $this->_set($key, $filter);
        }

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return FilterInterface
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $keys = $this->giGetPSRFormatParser()->parseWithPrefixGet($method);
        } catch (\Exception $exception) {
            $keys = null;
            $this->giThrowMagicMethodException($method);
        }

        $keys = array_filter(explode(static::KEY_SEPARATOR, $keys));

        $f = function($key)
        {
            return $this->giGetCamelCaseConverter()->convertToHyphenLowerCase($key);
        };
        $keys = array_map($f, $keys);

        return $this->findNodeRecursive($keys);
    }

    /**
     * @param array $keys
     * @return FilterInterface
     * @throws \Exception
     */
    public function findNodeRecursive(array $keys)
    {
        if (empty($keys)) {
            $this->giThrowIsEmptyException('Keys for recursive search');
        }

        $localKey = array_shift($keys);

        $result = $this->_get($localKey);

        if (!empty($keys)) {
            if ($result instanceof ContainerInterface) {
                $result = $result->findNodeRecursive($keys);
            } else {
                $this->giThrowNotFoundException('Node in recursive search');
            }
        }

        return $result;
    }
}