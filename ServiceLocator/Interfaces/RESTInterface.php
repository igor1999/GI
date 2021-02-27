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
namespace GI\ServiceLocator\Interfaces;

use GI\REST\Request\Factory\FactoryInterface as RequestFactoryInterface;
use GI\REST\Request\Server\ServerInterface;
use GI\CLI\CommandLine\CommandLineInterface;
use GI\REST\Response\Factory\FactoryInterface as ResponseFactoryInterface;
use GI\REST\Route\Factory\FactoryInterface as RouteFactoryInterface;
use GI\REST\Route\RouteInterface;
use GI\REST\URL\Builder\BuilderInterface as URLBuilderInterface;

interface RESTInterface
{
    /**
     * @return RequestFactoryInterface
     */
    public function getRequest();

    /**
     * @return RequestFactoryInterface
     */
    public function createRequestFactory();

    /**
     * @param RequestFactoryInterface $request
     * @return static
     * @throws \Exception
     */
    public function setRequest(RequestFactoryInterface $request);

    /**
     * @return ServerInterface
     */
    public function getServer();

    /**
     * @return CommandLineInterface
     */
    public function getCommandLine();

    /**
     * @return RouteInterface
     * @throws \Exception
     */
    public function getRoute();

    /**
     * @param RouteInterface $route
     * @return static
     * @throws \Exception
     */
    public function setRoute(RouteInterface $route);

    /**
     * @param string|null $caller
     * @return RouteFactoryInterface
     */
    public function getRouteFactory(string $caller = null);

    /**
     * @param string|null $caller
     * @return ResponseFactoryInterface
     */
    public function getResponseFactory(string $caller = null);

    /**
     * @param string|null $caller
     * @return URLBuilderInterface
     */
    public function createURLBuilder(string $caller = null);
}