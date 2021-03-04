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
namespace GI\SocketDemon\Socket\Client\Item;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\SocketDemon\Exchange\Request\Common\CommonInterface as CommonRequestInterface;
use GI\SocketDemon\Exchange\Request\Expiration\ExpirationInterface as ExpirationRequestInterface;
use GI\SocketDemon\Exchange\Request\Waiting\WaitingInterface as WaitingRequestInterface;
use GI\SocketDemon\Socket\Server\ServerInterface as ServerSocketInterface;
use GI\SocketDemon\Shell\ShellInterface;
use GI\SocketDemon\Exchange\Response\Item\ItemInterface as ResponseInterface;
use GI\SocketDemon\Exchange\Response\Collection\CollectionInterface as ResponseCollectionInterface;
use GI\Logger\LoggerInterface;
use GI\SocketDemon\Socket\Client\Item\Context\ContextInterface;

class Item implements ItemInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_BUFFER_LENGTH = 2048;


    /**
     * @var string
     */
    private $id = '';

    /**
     * @var bool
     */
    private $connected= false;

    /**
     * @var string
     */
    private $session = '';

    /**
     * @var ServerSocketInterface
     */
    private $serverSocket;

    /**
     * @var resource
     */
    private $socket;

    /**
     * @var int
     */
    private $bufferLength = self::DEFAULT_BUFFER_LENGTH;

    /**
     * @var bool
     */
    private $waiting = true;

    /**
     * @var int
     */
    private $expirationTime;

    /**
     * @var int
     */
    private $confirmationInterval = 0;

    /**
     * @var int
     */
    private $inactivityInterval = 0;

    /**
     * @var CommonRequestInterface
     */
    private $commonRequest;

    /**
     * @var ExpirationRequestInterface
     */
    private $expirationRequest;

    /**
     * @var WaitingRequestInterface
     */
    private $waitingRequest;

    /**
     * @var ShellInterface
     */
    private $shell;

    /**
     * @var ResponseCollectionInterface
     */
    private $responseCollection;

    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->id = $this->createId();

        $this->serverSocket = $this->giGetSocketDemonFactory()->createServerSocket();

        $this->commonRequest     = $this->giGetSocketDemonFactory()->createCommonRequest()->setId($this->id);
        $this->expirationRequest = $this->giGetSocketDemonFactory()->createExpirationRequest()->setId($this->id);
        $this->waitingRequest    = $this->giGetSocketDemonFactory()->createWaitingRequest()->setId($this->id);

        $this->shell = $this->giGetSocketDemonFactory()->createShell();

        $this->responseCollection = $this->giGetSocketDemonFactory()->createResponseCollection();

        try {
            $this->logger = $this->giCreateLogger();
        } catch (\Exception $e) {}

        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);

            try {
                $this->bufferLength = $context->getBufferLength();
            } catch (\Exception $e) {}
            $this->confirmationInterval = $context->getConfirmationInterval();
            $this->inactivityInterval   = $context->getInactivityInterval();
        } catch (\Exception $e) {}
    }

    /**
     * @return string
     */
    protected function createId()
    {
        $time = microtime(true) * 1000;

        return spl_object_hash($this) . '-' . $time;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->connected;
    }

    /**
     * @param bool $connected
     * @return Item
     */
    protected function setConnected(bool $connected)
    {
        $this->connected = $connected;

        return $this;
    }

    /**
     * @return string
     */
    protected function getSession()
    {
        return $this->session;
    }

    /**
     * @param string $session
     * @return static
     */
    protected function setSession(string $session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return ServerSocketInterface
     */
    protected function getServerSocket()
    {
        return $this->serverSocket;
    }

    /**
     * @return resource
     * @throws \Exception
     */
    public function getSocket()
    {
        if (!$this->isAlive()) {
            $this->giThrowCommonException('Socket does not opened');
        }

        return $this->socket;
    }

    /**
     * @return bool
     */
    public function isAlive()
    {
        return is_resource($this->socket);
    }

    /**
     * @return int
     */
    protected function getBufferLength()
    {
        return $this->bufferLength;
    }

    /**
     * @return bool
     */
    protected function isWaiting()
    {
        return $this->waiting;
    }

    /**
     * @param bool $waiting
     * @return static
     */
    protected function setWaiting(bool $waiting)
    {
        $this->waiting = $waiting;

        return $this;
    }

    /**
     * @return int
     */
    protected function getExpirationTime()
    {
        return $this->expirationTime;
    }

    /**
     * @return static
     */
    protected function setExpirationTime()
    {
        if ($this->waiting && $this->confirmationInterval > 0) {
            $this->expirationTime = time() + $this->confirmationInterval;
        } elseif (!$this->waiting && $this->inactivityInterval > 0) {
            $this->expirationTime = time() + $this->inactivityInterval;
        } else {
            $this->expirationTime = 0;
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function isExpired()
    {
        return !empty($this->expirationTime) && (time() > $this->expirationTime);
    }

    /**
     * @return int
     */
    protected function getConfirmationInterval()
    {
        return $this->confirmationInterval;
    }

    /**
     * @return int
     */
    protected function getInactivityInterval()
    {
        return $this->inactivityInterval;
    }

    /**
     * @return CommonRequestInterface
     */
    protected function getCommonRequest()
    {
        return $this->commonRequest;
    }

    /**
     * @return ExpirationRequestInterface
     */
    protected function getExpirationRequest()
    {
        return $this->expirationRequest;
    }

    /**
     * @return WaitingRequestInterface
     */
    protected function getWaitingRequest()
    {
        return $this->waitingRequest;
    }

    /**
     * @return ShellInterface
     */
    protected function getShell()
    {
        return $this->shell;
    }

    /**
     * @return ResponseCollectionInterface
     */
    public function getResponseCollection()
    {
        return $this->responseCollection;
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
     * @return bool
     */
    public function accept()
    {
        $this->socket = $this->getServerSocket()->accept();

        if ($this->isAlive()) {
            socket_set_nonblock($this->socket);

            $this->setWaiting(true)->setExpirationTime();
        }

        return $this->isAlive();
    }

    /**
     * @return string|false
     */
    protected function read()
    {
        return socket_read($this->socket, $this->bufferLength);
    }

    /**
     * @param string $data
     * @return static
     */
    protected function write(string $data)
    {
        socket_write($this->socket, $data);

        return $this;
    }

    /**
     * @param string $title
     * @param string $message
     * @return static
     */
    protected function kill(string $title, string $message)
    {
        socket_close($this->socket);

        $this->socket = null;

        try {
            $this->getLogger()->log(static::class, $title, $message);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @return static
     */
    public function send()
    {
        $this->getResponseCollection()->clean();

        if ($this->isAlive() && $this->connected) {
            $data = $this->read();

            if (empty($data) && $this->waiting && $this->isExpired()) {
                $this->kill('Not confirmed', 'Connection was not confirmed');
            } elseif (empty($data) && !$this->waiting && $this->isExpired()) {
                $request = $this->getExpirationRequest()->setSession($this->session);
            } elseif (!empty($data) && $this->waiting) {
                $this->setSession($data);
                $request = $this->getWaitingRequest()->setSession($this->session);
            } elseif (!empty($data)) {
                $request = $this->getCommonRequest()->setData($data)->setSession($this->session);
            }

            if (!empty($request)) {
                if (!$this->waiting) {
                    $this->setExpirationTime();
                }

                try {
                    $this->responseCollection = $this->getShell()->send($request);
                } catch (\Exception $e) {
                    try {
                        $this->getLogger()->log(static::class,'Invalid response', $e->getMessage());
                    } catch (\Exception $e) {}
                }
            }
        } elseif ($this->isAlive() && !$this->connected) {
            $this->read();
            $this->setConnected(true);
        }

        return $this;
    }

    /**
     * @param ResponseInterface $response
     * @return static
     */
    public function response(ResponseInterface $response)
    {
        if ($this->isAlive()) {
            if ($response->isConfirmed()) {
                $this->setWaiting(false)->setExpirationTime();
            }

            if ($response->hasData()) {
                $this->write($response->getData());
            }

            if ($response->isKill()) {
                $this->kill('Kill by application', 'Connection killed by application');
            }
        }

        return $this;
    }
}