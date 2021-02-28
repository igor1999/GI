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
namespace GI\SocketDemon\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\SocketDemon\Exchange\Request\Common\Common as CommonRequest;
use GI\SocketDemon\Exchange\Request\Expiration\Expiration as ExpirationRequest;
use GI\SocketDemon\Exchange\Request\Waiting\Waiting as WaitingRequest;
use GI\SocketDemon\Exchange\Request\PushCall\PushCall as PushCallRequest;
use GI\SocketDemon\Exchange\Request\Creator\Creator as RequestCreator;

use GI\SocketDemon\Exchange\Response\Item\Item as Response;
use GI\SocketDemon\Exchange\Response\Collection\Collection as ResponseCollection;

use GI\SocketDemon\Shell\Shell;

use GI\SocketDemon\Socket\Server\Server as ServerSocket;
use GI\SocketDemon\Socket\Client\Item\Item as ClientSocket;
use GI\SocketDemon\Socket\Client\Collection\Collection as ClientSocketCollection;

use GI\SocketDemon\Demon\Demon;


use GI\SocketDemon\Exchange\Request\RequestInterface;

use GI\SocketDemon\Exchange\Request\Common\CommonInterface as CommonRequestInterface;
use GI\SocketDemon\Exchange\Request\Expiration\ExpirationInterface as ExpirationRequestInterface;
use GI\SocketDemon\Exchange\Request\Waiting\WaitingInterface as WaitingRequestInterface;
use GI\SocketDemon\Exchange\Request\PushCall\PushCallInterface as PushCallRequestInterface;
use GI\SocketDemon\Exchange\Request\Creator\CreatorInterface as RequestCreatorInterface;

use GI\SocketDemon\Exchange\Response\Item\ItemInterface as ResponseInterface;
use GI\SocketDemon\Exchange\Response\Collection\CollectionInterface as ResponseCollectionInterface;

use GI\SocketDemon\Shell\ShellInterface;

use GI\SocketDemon\Socket\Server\ServerInterface as ServerSocketInterface;
use GI\SocketDemon\Socket\Client\Item\ItemInterface as ClientSocketInterface;
use GI\SocketDemon\Socket\Client\Collection\CollectionInterface as ClientSocketCollectionInterface;

use GI\SocketDemon\Demon\DemonInterface;

/**
 * Class Factory
 * @package GI\SocketDemon\Factory
 *
 * @method CommonRequestInterface createCommonRequest()
 * @method ExpirationRequestInterface createExpirationRequest()
 * @method WaitingRequestInterface createWaitingRequest()
 * @method PushCallRequestInterface createPushCallRequest()
 * @method RequestCreatorInterface createRequestCreator()
 *
 * @method ResponseInterface createResponse()
 * @method ResponseCollectionInterface createResponseCollection()
 *
 * @method ShellInterface createShell()
 *
 * @method ServerSocketInterface createServerSocket()
 * @method ClientSocketInterface createClientSocket()
 * @method ClientSocketCollectionInterface createClientSocketCollection()
 *
 * @method DemonInterface createDemon()
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()
            ->add(RequestInterface::class)->add(RequestCreatorInterface::class)
            ->add(ResponseInterface::class)->add(ResponseCollectionInterface::class)
            ->add(ShellInterface::class)
            ->add(ServerSocketInterface::class)->add(ClientSocketInterface::class)
            ->add(ClientSocketCollectionInterface::class)
            ->add(DemonInterface::class);

        $this->setNamed('CommonRequest', CommonRequest::class)
            ->setNamed('ExpirationRequest',ExpirationRequest::class)
            ->setNamed('WaitingRequest',WaitingRequest::class)
            ->setNamed('PushCallRequest',PushCallRequest::class)
            ->setNamed('RequestCreator',RequestCreator::class)

            ->setNamed('Response',Response::class)
            ->setNamed('ResponseCollection',ResponseCollection::class)

            ->set(Shell::class)

            ->setNamed('ServerSocket',ServerSocket::class, true)
            ->setNamed('ClientSocket',ClientSocket::class)
            ->setNamed('ClientSocketCollection',ClientSocketCollection::class)

            ->set(Demon::class);
    }
}