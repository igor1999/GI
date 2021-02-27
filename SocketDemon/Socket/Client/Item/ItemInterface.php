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

use GI\SocketDemon\Exchange\Response\Collection\CollectionInterface as ResponseCollectionInterface;
use GI\SocketDemon\Exchange\Response\Item\ItemInterface as ResponseInterface;

interface ItemInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return bool
     */
    public function isConnected();

    /**
     * @return resource
     * @throws \Exception
     */
    public function getSocket();

    /**
     * @return bool
     */
    public function isAlive();

    /**
     * @return ResponseCollectionInterface
     */
    public function getResponseCollection();

    /**
     * @return bool
     */
    public function accept();

    /**
     * @return static
     */
    public function send();

    /**
     * @param ResponseInterface $response
     * @return static
     */
    public function response(ResponseInterface $response);
}