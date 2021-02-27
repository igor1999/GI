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
namespace GI\ServiceLocator\AwareTraits;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\REST\Request\Factory\FactoryInterface as RequestFactoryInterface;
use GI\REST\Request\Server\ServerInterface;
use GI\CLI\CommandLine\CommandLineInterface;
use GI\REST\Route\Factory\FactoryInterface as RouteFactoryInterface;
use GI\REST\Response\Factory\FactoryInterface as ResponseFactoryInterface;
use GI\REST\URL\Builder\BuilderInterface as URLBuilderInterface;

trait RESTAwareTrait
{
    /**
     * @return RequestFactoryInterface
     */
    protected function giGetRequest()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getRequest();
    }

    /**
     * @return ServerInterface
     */
    protected function giGetServer()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getServer();
    }

    /**
     * @return CommandLineInterface
     */
    protected function giGetCommandLine()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getCommandLine();
    }

    /**
     * @return RouteFactoryInterface
     */
    protected function giGetRouteFactory()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getRouteFactory(static::class);
    }

    /**
     * @return ResponseFactoryInterface
     */
    protected function giGetResponseFactory()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getResponseFactory(static::class);
    }

    /**
     * @return URLBuilderInterface
     */
    protected function giCreateURLBuilder()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->createURLBuilder(static::class);
    }
}