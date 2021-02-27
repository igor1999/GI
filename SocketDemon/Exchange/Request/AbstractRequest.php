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
namespace GI\SocketDemon\Exchange\Request;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\HydrationTrait;

use GI\SocketDemon\Exchange\Request\Context\ContextInterface;

abstract class AbstractRequest implements RequestInterface
{
    use ServiceLocatorAwareTrait, HydrationTrait;


    /**
     * @var string
     */
    private $route = '';

    /**
     * @var string
     */
    private $demon = '';

    /**
     * @var ContextInterface
     */
    private $context;


    /**
     * AbstractRequest constructor.
     */
    public function __construct()
    {
        try {
            $this->context = $this->giGetDi(ContextInterface::class);
        } catch (\Exception $exception) {}

        try {
            $this->route = $this->getContext()->getRoute($this);
        } catch (\Exception $e) {}

        try {
            $this->demon = $this->getContext()->getDemon();
        } catch (\Exception $e) {}
    }

    /**
     * @return ContextInterface
     * @throws \Exception
     */
    protected function getContext()
    {
        if (!($this->context instanceof ContextInterface)) {
            $this->giThrowNotSetException('Context');
        }

        return $this->context;
    }

    /**
     * @extract
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @hydrate
     * @param string $route
     * @return static
     */
    public function setRoute(string $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @extract
     * @return string
     */
    public function getDemon()
    {
        return $this->demon;
    }

    /**
     * @hydrate
     * @param string $demon
     * @return static
     */
    public function setDemon(string $demon)
    {
        $this->demon = $demon;

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function extract()
    {
        $result = $this->giGetClassMeta()->extract($this);
        $result[self::CLASS_ARGUMENT_NAME] = static::class;

        return $result;
    }
}