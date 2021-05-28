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
namespace GI\SocketDemon\Socket\Server;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\SocketDemon\Socket\Exception\ExceptionAwareTrait;

use GI\SocketDemon\Socket\Server\Context\ContextInterface;

class Server implements ServerInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    /**
     * @var resource
     */
    private $socket;


    /**
     * Server constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if (!is_resource($this->socket)) {
            $this->throwSocketException();
        }

        /** @var ContextInterface $context */
        $context = $this->getGiServiceLocator()->getDependency(ContextInterface::class);

        if (!socket_bind($this->socket, $context->getAddress(), $context->getPort())) {
            $this->throwSocketException();
        }

        if (!socket_listen($this->socket)) {
            $this->throwSocketException();
        }

        socket_set_nonblock($this->socket);

        return $this;
    }

    /**
     * @return resource
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @return resource
     */
    public function accept()
    {
        return @socket_accept($this->socket);
    }
}