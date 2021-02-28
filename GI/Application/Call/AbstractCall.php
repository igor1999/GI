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
namespace GI\Application\Call;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Closing\ClosingTrait;

use GI\Application\Module\Provider\ProviderInterface;
use GI\Application\Module\Locator\LocatorInterface as ModuleLocatorInterface;
use GI\DI\DIInterface;
use GI\Event\ManagerInterface as EventManagerInterface;
use GI\REST\Route\RouteInterface;
use GI\Storage\Collection\ClosureCollection\ArrayList\Closable\ClosableInterface as HandlersInterface;
use GI\REST\Request\Factory\FactoryInterface as RequestFactoryInterface;

abstract class AbstractCall implements CallInterface
{
    use ServiceLocatorAwareTrait, ClosingTrait;


    /**
     * @var ProviderInterface
     */
    private $provider;

    /**
     * @var ModuleLocatorInterface
     */
    private $moduleLocator;

    /**
     * @var HandlersInterface
     */
    private $handlers;

    /**
     * @var DIInterface
     */
    private $di;

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * @var RouteInterface
     */
    private $route;

    /**
     * @var RequestFactoryInterface
     */
    private $request;


    /**
     * AbstractCall constructor.
     * @param RouteInterface $route
     * @param \Closure $handler
     * @throws \Exception
     */
    public function __construct(RouteInterface $route, \Closure $handler)
    {
        $this->handlers = $this->giGetStorageFactory()->createClosureArrayListClosable()->add($handler);
        $this->route    = $route;
        $this->request  = $this->giGetServiceLocator()->createRequestFactory();
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->setClosed(true);

        $this->getHandlers()->close();
        $this->getRoute()->close();
        $this->getRequest()->close();

        return $this;
    }

    /**
     * @return ProviderInterface
     * @throws \Exception
     */
    protected function getProvider()
    {
        if (!($this->provider instanceof ProviderInterface)) {
            $this->giThrowNotSetException('Provider');
        }

        return $this->provider;
    }

    /**
     * @param ProviderInterface $provider
     * @return static
     * @throws \Exception
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->validateClosing();

        $this->provider = $provider;

        return $this;
    }

    /**
     * @return ModuleLocatorInterface
     * @throws \Exception
     */
    protected function getModuleLocator()
    {
        if (!($this->moduleLocator instanceof ModuleLocatorInterface)) {
            $this->giThrowNotSetException('Module Locator');
        }

        return $this->moduleLocator;
    }

    /**
     * @param ModuleLocatorInterface $moduleLocator
     * @return static
     * @throws \Exception
     */
    public function setModuleLocator(ModuleLocatorInterface $moduleLocator)
    {
        $this->validateClosing();

        $this->moduleLocator = $moduleLocator;

        return $this;
    }

    /**
     * @return HandlersInterface
     */
    protected function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @return bool
     */
    public function hasDi()
    {
        return ($this->di instanceof DIInterface);
    }

    /**
     * @return DIInterface
     * @throws \Exception
     */
    protected function getDi()
    {
        if (!$this->hasDi()) {
            $this->giThrowNotSetException('DI');
        }

        return $this->di;
    }

    /**
     * @param DIInterface $di
     * @return static
     * @throws \Exception
     */
    public function setDi(DIInterface $di)
    {
        $this->validateClosing();

        $this->di = $di;

        return $this;
    }

    /**
     * @param DIInterface $di
     * @return bool
     * @throws \Exception
     */
    public function setDiIfNotSet(DIInterface $di)
    {
        if ($result = !$this->hasDi()) {
            $this->setDi($di);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function hasEventManager()
    {
        return ($this->eventManager instanceof EventManagerInterface);
    }

    /**
     * @return EventManagerInterface
     * @throws \Exception
     */
    protected function getEventManager()
    {
        if (!$this->hasEventManager()) {
            $this->giThrowNotSetException('Event Manager');
        }

        return $this->eventManager;
    }

    /**
     * @param EventManagerInterface $eventManager
     * @return static
     * @throws \Exception
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->validateClosing();

        $this->eventManager = $eventManager;

        return $this;
    }

    /**
     * @param EventManagerInterface $eventManager
     * @return bool
     * @throws \Exception
     */
    public function setEventManagerIfNotSet(EventManagerInterface $eventManager)
    {
        if ($result = !$this->hasEventManager()) {
            $this->setEventManager($eventManager);
        }

        return $result;
    }

    /**
     * @return RouteInterface
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return RequestFactoryInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function saveCallAndModuleContents()
    {
        if (!$this->giGetServiceLocator()->isClosed()) {
            $this->giGetServiceLocator()->setExceptionHandler();
            $this->giGetServiceLocator()->setRoute($this->getRoute());
            $this->giGetServiceLocator()->setRequest($this->getRequest());
        }

        $this->saveDI()->saveEventManager()->saveSessionExchangeClasses();

        return $this;
    }

    /**
     * @return static
     */
    protected function saveDI()
    {
        if (!$this->giGetServiceLocator()->isClosed()) {
            try {
                $this->giGetServiceLocator()->setDi($this->getDi());
            } catch (\Exception $e) {
                try {
                    $this->giGetServiceLocator()->setDi($this->getProvider()->getDI());
                } catch (\Exception $e) {}
            }
        }

        return $this;
    }

    /**
     * @return static
     */
    protected function saveEventManager()
    {
        if (!$this->giGetServiceLocator()->isClosed()) {
            try {
                $this->giGetServiceLocator()->mergeEvents($this->getModuleLocator()->getEventManager());
            } catch (\Exception $e) {}

            try {
                $this->giGetServiceLocator()->mergeEvents($this->getEventManager());
            } catch (\Exception $e) {}
        }

        return $this;
    }

    /**
     * @return static
     */
    protected function saveSessionExchangeClasses()
    {
        if (!$this->giGetServiceLocator()->isClosed()) {
            try {
                $this->giGetServiceLocator()->setSessionExchangeClasses(
                    $this->getModuleLocator()->getSessionExchangeClasses()
                );
            } catch (\Exception $e) {}
        }

        return $this;
    }
}