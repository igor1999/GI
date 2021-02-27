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
namespace GI\SocketDemon\Exchange\Processor;

use GI\SocketDemon\Exchange\Response\Collection\Collection as ResponseCollection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\SocketDemon\Exchange\Request\RequestInterface;
use GI\SocketDemon\Exchange\Response\Collection\CollectionInterface as ResponseCollectionInterface;

abstract class AbstractProcessor implements ProcessorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ResponseCollectionInterface
     */
    private $responseCollection;


    /**
     * AbstractProcessor constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createRequest()->getRequest()->hydrate($this->giGetCommandLine()->extract());

        $this->createResponseCollection();
    }

    /**
     * @return static
     */
    abstract protected function createRequest();

    /**
     * @return RequestInterface
     */
    abstract protected function getRequest();

    /**
     * @return static
     * @throws \Exception
     */
    protected function createResponseCollection()
    {
        $this->responseCollection = $this->giGetDi(
            ResponseCollectionInterface::class, ResponseCollection::class
        );

        return $this;
    }

    /**
     * @return ResponseCollectionInterface
     */
    protected function getResponseCollection()
    {
        return $this->responseCollection;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getJSON()
    {
        return $this->getResponseCollection()->getJSON();
    }
}