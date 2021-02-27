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
namespace GI\ServiceLocator\Traits;

use GI\REST\Request\Factory\Factory as RequestFactory;
use GI\REST\Response\Factory\Factory as ResponseFactory;
use GI\REST\Route\Factory\Factory as RouteFactory;
use GI\REST\URL\Builder\Builder as URLBuilder;

use GI\REST\Request\Factory\FactoryInterface as RequestFactoryInterface;
use GI\REST\Request\Server\ServerInterface;
use GI\CLI\CommandLine\CommandLineInterface;
use GI\REST\Response\Factory\FactoryInterface as ResponseFactoryInterface;
use GI\REST\Route\Factory\FactoryInterface as RouteFactoryInterface;
use GI\REST\Route\RouteInterface;
use GI\REST\URL\Builder\BuilderInterface as URLBuilderInterface;
use GI\ServiceLocator\ServiceLocatorInterface;

trait RESTTrait
{
    /**
     * @var RequestFactoryInterface
     */
    private $request;

    /**
     * @var RouteInterface;
     */
    private $route;

    /**
     * @var RouteFactoryInterface
     */
    private $routeFactory;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;


    /**
     * @return RequestFactoryInterface
     */
    public function getRequest()
    {
        if (!($this->request instanceof RequestFactoryInterface)) {
            $this->request = $this->createRequestFactory();
        }

        return $this->request;
    }

    /**
     * @return RequestFactoryInterface
     */
    public function createRequestFactory()
    {
        return new RequestFactory();
    }

    /**
     * @param RequestFactoryInterface $request
     * @return static
     */
    public function setRequest(RequestFactoryInterface $request)
    {
        $this->validateClosing();

        $this->request = $request;

        return $this;
    }

    /**
     * @return ServerInterface
     */
    public function getServer()
    {
        return $this->getRequest()->getServer();
    }

    /**
     * @return CommandLineInterface
     */
    public function getCommandLine()
    {
        return $this->getServer()->getCommandLine();
    }

    /**
     * @return RouteInterface
     * @throws \Exception
     */
    public function getRoute()
    {
        if (!($this->route instanceof RouteInterface)) {
            $this->throwNotSetException('Global route', static::class);
        }

        return $this->route;
    }

    /**
     * @param RouteInterface $route
     * @return static
     */
    public function setRoute(RouteInterface $route)
    {
        $this->validateClosing();

        $this->route = $route;

        return $this;
    }

    /**
     * @param string|null $caller
     * @return RouteFactoryInterface
     */
    public function getRouteFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(RouteFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->routeFactory instanceof RouteFactoryInterface)) {
                $this->routeFactory = new RouteFactory();
            }

            $result = $this->routeFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return ResponseFactoryInterface
     */
    public function getResponseFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(ResponseFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->responseFactory instanceof ResponseFactoryInterface)) {
                $this->responseFactory = new ResponseFactory();
            }

            $result = $this->responseFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return URLBuilderInterface
     */
    public function createURLBuilder(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(URLBuilderInterface::class, $caller);
        } catch (\Exception $e) {
            $result = new URLBuilder();
        }

        return $result;
    }
}