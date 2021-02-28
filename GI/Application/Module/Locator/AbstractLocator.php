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
namespace GI\Application\Module\Locator;

use GI\Event\Manager as EventManager;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Application\Module\Provider\ProviderInterface;
use GI\Application\Call\Web\CallInterface as WebCallInterface;
use GI\Application\Call\CLI\CallInterface as CLICallInterface;
use GI\Event\ManagerInterface as EventManagerInterface;

abstract class AbstractLocator implements LocatorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ProviderInterface[]
     */
    private $providers = [];


    /**
     * @return ProviderInterface[]
     */
    protected function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param ProviderInterface $provider
     * @return static
     */
    protected function add(ProviderInterface $provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * @return WebCallInterface[]
     * @throws \Exception
     */
    public function getWebCalls()
    {
        $calls = [];

        foreach ($this->getProviders() as $provider) {
            $callContainer = $provider->getWebCallContainer();

            $f = function(WebCallInterface $call) use ($provider)
            {
                $call->setProvider($provider)->setModuleLocator($this);
            };

            $providerCalls = $callContainer->create();
            array_map($f, $providerCalls);

            $calls = array_merge($calls, $providerCalls);
        }

        return $calls;
    }

    /**
     * @return array|CLICallInterface[]
     * @throws \Exception
     */
    public function getCLICalls()
    {
        $calls = [];

        foreach ($this->getProviders() as $provider) {
            $callContainer = $provider->getCLICallContainer();

            $f = function(CLICallInterface $call) use ($provider)
            {
                $call->setProvider($provider)->setModuleLocator($this);
            };

            $providerCalls = $callContainer->create();
            array_map($f, $providerCalls);

            $calls = array_merge($calls, $providerCalls);
        }

        return $calls;
    }

    /**
     * @return EventManagerInterface
     * @throws \Exception
     */
    public function getEventManager()
    {
        $eventManager = $this->createEventManager();

        foreach ($this->getProviders() as $provider) {
            $providerEventManager = $provider->getEventManager();

            $eventManager->merge($providerEventManager);
        }

        return $eventManager;
    }

    /**
     * @return EventManager
     */
    protected function createEventManager()
    {
        return new EventManager();
    }

    /**
     * @return string[]
     */
    public function getSessionExchangeClasses()
    {
        $classes = [];

        foreach ($this->getProviders() as $provider) {
            $classes = array_merge($classes, $provider->getSessionExchangeClasses());
        }

        return array_unique($classes);
    }
}