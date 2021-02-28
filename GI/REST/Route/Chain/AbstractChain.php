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
namespace GI\REST\Route\Chain;

use GI\REST\Route\AbstractRoute;

use GI\REST\Route\RouteInterface;
use GI\REST\Request\Server\ServerInterface;

abstract class AbstractChain extends AbstractRoute implements ChainInterface
{
    /**
     * @var RouteInterface[]
     */
    private $items = [];


    /**
     * @return static
     */
    public function close()
    {
        $this->setClosed(true);

        foreach ($this->items as $item) {
            $item->close();
        }

        return $this;
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
     * @return RouteInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @return RouteInterface[]
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
     * @param RouteInterface $item
     * @return static
     * @throws \Exception
     */
    protected function _set($key, RouteInterface $item)
    {
        $this->validateClosing();

        $this->items[$key] = $item;

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public function remove(string $key)
    {
        $this->validateClosing();

        if ($result = $this->has($key)) {
            unset($this->items[$key]);
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

        $this->items = [];

        return $this;
    }

    /**
     * @param array $keys
     * @return ChainInterface
     * @throws \Exception
     */
    public function findChainRecursive(array $keys)
    {
        if (empty($keys)) {
            $result = $this;
        } else {
            $key = array_shift($keys);
            $result = $this->get($key);

            if ($result instanceof ChainInterface) {
                $result = $result->findChainRecursive($keys);
            } else {
                $this->giThrowNotFoundException('Chain', $key);
            }
        }

        return $result;
    }

    /**
     * @param string $param
     * @return array
     */
    protected function parseParam($param)
    {
        $keys = explode('', $param);

        $paramKey = array_pop($keys);
        $routeKey = array_pop($keys);

        return [$keys, $routeKey, $paramKey];
    }

    /**
     * @param string $param
     * @return bool
     */
    public function hasParam(string $param)
    {
        list($keys, $routeKey, $paramKey) = $this->parseParam($param);

        try {
            $chain = $this->findChainRecursive($keys);

            $result = $chain->get($routeKey)->hasParam($paramKey);
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param string $param
     * @return string
     * @throws \Exception
     */
    public function getParam(string $param)
    {
        list($keys, $routeKey, $paramKey) = $this->parseParam($param);

        $chain = $this->findChainRecursive($keys);

        return $chain->get($routeKey)->getParam($paramKey);
    }

    /**
     * @param string $source
     * @return bool
     * @throws \Exception
     */
    public function validateByString(string $source)
    {
        $this->setSource($source);

        $f = function(RouteInterface $route) use ($source)
        {
            return $route->validateByString($source);
        };
        $results = array_map($f, $this->items);
        $result  = $this->fold($results);

        return $this->setValid($result)->isValid();
    }

    /**
     * @param ServerInterface $server
     * @return bool
     * @throws \Exception
     */
    public function validateByServer(ServerInterface $server)
    {
        $this->setSource('');

        $f = function(RouteInterface $route) use ($server)
        {
            return $route->validateByServer($server);
        };
        $results = array_map($f, $this->items);
        $result  = $this->fold($results);

        return $this->setValid($result)->isValid();
    }

    /**
     * @param array $results
     * @return bool
     */
    abstract protected function fold(array $results);
}