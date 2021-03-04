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
namespace GI\REST\Route\Chain\Web;

use GI\REST\Route\Chain\AbstractChain as Base;

use GI\REST\Route\WebInterface;
use GI\REST\Route\Segmented\Host\HostInterface;
use GI\REST\Route\Segmented\UriPath\UriPathInterface;
use GI\REST\Route\Simple\Method\MethodInterface;
use GI\REST\Route\Simple\Protocol\ProtocolInterface;

/**
 * Class AbstractChain
 * @package GI\REST\Route\Chain\Web
 *
 * @method bool hasMethod()
 * @method MethodInterface getMethod()
 * @method ChainInterface setMethod(MethodInterface $item)
 *
 * @method bool hasProtocol()
 * @method ProtocolInterface getProtocol()
 * @method ChainInterface setProtocol(ProtocolInterface $item)
 *
 * @method bool hasPath()
 * @method UriPathInterface getPath()
 * @method ChainInterface setPath(UriPathInterface $item)
 *
 * @method bool hasHost()
 * @method HostInterface getHost()
 * @method ChainInterface setHost(HostInterface $item)
 */
abstract class AbstractChain extends Base implements ChainInterface
{
    const KEY_CONSTANT_SUFFIX = '_KEY';


    const METHOD_KEY   = '_method';

    const PROTOCOL_KEY = '_protocol';

    const PATH_KEY     = '_path';

    const HOST_KEY     = '_host';


    /**
     * @param string $key
     * @return WebInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        /** @var WebInterface $result */
        $result = parent::get($key);

        return $result;
    }

    /**
     * @return WebInterface[]
     */
    public function getItems()
    {
        /** @var WebInterface[] $result */
        $result = parent::getItems();

        return $result;
    }

    /**
     * @param string $key
     * @param WebInterface $item
     * @return static
     * @throws \Exception
     */
    public function set(string $key, WebInterface $item)
    {
        $this->_set($key, $item);

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return static|bool|WebInterface
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $has = $this->giGetPSRFormatParser()->parseWithPrefixHas($method);
        } catch (\Exception $exception) {
            try {
                $get = $this->giGetPSRFormatParser()->parseWithPrefixGet($method);
            } catch (\Exception $exception) {
                try {
                    $set = $this->giGetPSRFormatParser()->parseWithPrefixSet($method);
                } catch (\Exception $exception) {
                    $this->giThrowMagicMethodException($method);
                }
            }
        }

        $result    = null;
        $constants = $this->giGetClassMeta()->getConstants();

        if (!empty($has)) {
            $param  = $constants->get(strtoupper($has) . static::KEY_CONSTANT_SUFFIX);
            $result = $this->has($param);
        } elseif (!empty($get)) {
            $param  = $constants->get(strtoupper($get) . static::KEY_CONSTANT_SUFFIX);
            $result = $this->get($param);
        } elseif (!empty($set)) {
            if (empty($arguments)) {
                $this->giThrowNotGivenException('Route for set');
            }
            $param  = $constants->get(strtoupper($set) . static::KEY_CONSTANT_SUFFIX);
            $result = $this->set($param, array_shift($arguments));
        }

        return $result;
    }

    /**
     * @return static
     */
    public function setDeleteMethod()
    {
        $this->setMethod($this->giGetRouteFactory()->createDeleteMethod());

        return $this;
    }

    /**
     * @return static
     */
    public function setGetMethod()
    {
        $this->setMethod($this->giGetRouteFactory()->createGetMethod());

        return $this;
    }

    /**
     * @return static
     */
    public function setPostMethod()
    {
        $this->setMethod($this->giGetRouteFactory()->createPostMethod());

        return $this;
    }

    /**
     * @return static
     */
    public function setPutMethod()
    {
        $this->setMethod($this->giGetRouteFactory()->createPutMethod());

        return $this;
    }

    /**
     * @return static
     */
    public function setHTTPProtocol()
    {
        $this->setMethod($this->giGetRouteFactory()->createHTTPProtocol());

        return $this;
    }

    /**
     * @return static
     */
    public function setHTTPSProtocol()
    {
        $this->setMethod($this->giGetRouteFactory()->createHTTPSProtocol());

        return $this;
    }
}