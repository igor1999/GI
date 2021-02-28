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

use GI\REST\Route\Chain\ChainInterface as BaseInterface;
use GI\REST\Route\WebInterface;
use GI\REST\Route\Segmented\Host\HostInterface;
use GI\REST\Route\Segmented\UriPath\UriPathInterface;
use GI\REST\Route\Simple\Method\MethodInterface;
use GI\REST\Route\Simple\Protocol\ProtocolInterface;

/**
 * Interface ChainInterface
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
interface ChainInterface extends BaseInterface, WebInterface
{
    /**
     * @param string $key
     * @return WebInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return WebInterface[]
     */
    public function getItems();

    /**
     * @param string $key
     * @param WebInterface $item
     * @return static
     * @throws \Exception
     */
    public function set(string $key, WebInterface $item);

    /**
     * @return static
     */
    public function setDeleteMethod();

    /**
     * @return static
     */
    public function setGetMethod();

    /**
     * @return static
     */
    public function setPostMethod();

    /**
     * @return static
     */
    public function setPutMethod();

    /**
     * @return static
     */
    public function setHTTPProtocol();

    /**
     * @return static
     */
    public function setHTTPSProtocol();
}