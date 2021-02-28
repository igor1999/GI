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
namespace GI\SocketDemon\Socket\Client\Collection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\SocketDemon\Shell\ShellInterface;
use GI\SocketDemon\Exchange\Request\PushCall\PushCallInterface as PushCallRequestInterface;
use GI\SocketDemon\Socket\Client\Item\ItemInterface as ClientSocketInterface;
use GI\SocketDemon\Exchange\Response\Collection\CollectionInterface as ResponseCollectionInterface;
use GI\Logger\LoggerInterface;
use GI\SocketDemon\Socket\Client\Collection\Context\ContextInterface;

class Collection implements CollectionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ClientSocketInterface[]
     */
    private $items = [];

    /**
     * @var int
     */
    private $limit = 0;

    /**
     * @var bool
     */
    private $pushCalls = false;

    /**
     * @var PushCallRequestInterface
     */
    private $pushCallRequest;

    /**
     * @var ShellInterface
     */
    private $shell;

    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * Collection constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);

            $this->limit     = $context->getLimit();
            $this->pushCalls = $context->allowPushCalls();
        } catch (\Exception $e) {}

        $this->pushCallRequest = $this->giGetSocketDemonFactory()->createPushCallRequest();

        $this->shell = $this->giGetSocketDemonFactory()->createShell();

        try {
            $this->logger = $this->giCreateLogger();
        } catch (\Exception $exception) {}
    }

    /**
     * @param string $id
     * @return bool
     */
    protected function has($id)
    {
        return isset($this->items[$id]);
    }

    /**
     * @param string $id
     * @return ClientSocketInterface
     * @throws \Exception
     */
    protected function get($id)
    {
        if (!$this->has($id)) {
            $this->giThrowNotInScopeException($id);
        }

        return $this->items[$id];
    }

    /**
     * @return ClientSocketInterface[]
     */
    protected function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    protected function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return bool
     */
    protected function isPushCalls()
    {
        return $this->pushCalls;
    }

    /**
     * @return PushCallRequestInterface
     */
    protected function getPushCallRequest()
    {
        return $this->pushCallRequest;
    }

    /**
     * @return ShellInterface
     */
    protected function getShell()
    {
        return $this->shell;
    }

    /**
     * @return LoggerInterface
     * @throws \Exception
     */
    protected function getLogger()
    {
        if (!($this->logger instanceof LoggerInterface)) {
            $this->giThrowNotSetException('Logger');
        }

        return $this->logger;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function send()
    {
        $this->accept();

        if ($this->select()) {
            foreach ($this->getItems() as $item) {
                $this->response($item->send()->getResponseCollection());
            }
        }

        $this->push()->refresh();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function accept()
    {
        if (empty($this->limit) || (count($this->items) < $this->limit)) {
            $clientSocket = $this->giGetSocketDemonFactory()->createClientSocket();

            if ($clientSocket->accept()) {
                $this->items[$clientSocket->getId()] = $clientSocket;
            }
        }

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function select()
    {
        $f = function(ClientSocketInterface $item)
        {
            return $item->isAlive();
        };
        $items = array_filter($this->items, $f);

        $f = function(ClientSocketInterface $item)
        {
            return $item->getSocket();
        };
        $read = array_map($f, $items);

        if (empty($read)) {
            $result = false;
        } else {
            $write = null;
            $except = null;

            $result = (socket_select($read, $write, $except, 0) > 0);
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function push()
    {
        if ($this->pushCalls) {
            try {
                $responseCollection = $this->getShell()->send($this->getPushCallRequest());
                $this->response($responseCollection);
            } catch (\Exception $e) {
                try {
                    $this->getLogger()->log(static::class, 'Invalid response', $e->getMessage());
                } catch (\Exception $exception) {}
            }
        }

        return $this;
    }

    /**
     * @param ResponseCollectionInterface $responseCollection
     * @return static
     */
    protected function response(ResponseCollectionInterface $responseCollection)
    {
        foreach ($responseCollection->getItems() as $response) {
            $id = $response->getId();

            try {
                $this->get($id)->response($response);
            } catch (\Exception $e) {}
        }

        return $this;
    }

    /**
     * @return static
     */
    protected function refresh()
    {
        $f = function(ClientSocketInterface $item)
        {
            return $item->isAlive();
        };

        $this->items = array_filter($this->items, $f);

        return $this;
    }
}