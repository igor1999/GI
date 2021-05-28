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
namespace GI\Application\Module\CallContainer;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ExtractionTrait;

use GI\Application\Call\CallInterface;
use GI\DI\DIInterface;
use GI\Event\ManagerInterface as EventManagerInterface;

abstract class AbstractContainer implements ContainerInterface
{
    use ServiceLocatorAwareTrait, ExtractionTrait;


    /**
     * @var DIInterface
     */
    private $localDI;

    /**
     * @var DIInterface
     */
    private $recursiveDI;

    /**
     * @var EventManagerInterface
     */
    private $localEventManager;

    /**
     * @var EventManagerInterface
     */
    private $recursiveEventManager;


    /**
     * @return DIInterface
     * @throws \Exception
     */
    protected function getLocalDI()
    {
        if (!($this->localDI instanceof DIInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('Local DI');
        }

        return $this->localDI;
    }

    /**
     * @param DIInterface $localDI
     * @return static
     */
    protected function setLocalDI(DIInterface $localDI)
    {
        $this->localDI = $localDI;

        return $this;
    }

    /**
     * @return DIInterface
     * @throws \Exception
     */
    protected function getRecursiveDI()
    {
        if (!($this->recursiveDI instanceof DIInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('Recursive DI');
        }

        return $this->recursiveDI;
    }

    /**
     * @param DIInterface $recursiveDI
     * @return static
     */
    protected function setRecursiveDI(DIInterface $recursiveDI)
    {
        $this->recursiveDI = $recursiveDI;

        return $this;
    }

    /**
     * @return EventManagerInterface
     * @throws \Exception
    */
    protected function getLocalEventManager()
    {
        if (!($this->localEventManager instanceof EventManagerInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('Local Event Manager');
        }

        return $this->localEventManager;
    }

    /**
     * @param EventManagerInterface $localEventManager
     * @return static
     */
    protected function setLocalEventManager(EventManagerInterface $localEventManager)
    {
        $this->localEventManager = $localEventManager;

        return $this;
    }

    /**
     * @return EventManagerInterface
     * @throws \Exception
     */
    protected function getRecursiveEventManager()
    {
        if (!($this->recursiveEventManager instanceof EventManagerInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('Recursive Event Manager');
        }

        return $this->recursiveEventManager;
    }

    /**
     * @param EventManagerInterface $recursiveEventManager
     * @return static
     */
    protected function setRecursiveEventManager(EventManagerInterface $recursiveEventManager)
    {
        $this->recursiveEventManager = $recursiveEventManager;

        return $this;
    }

    /**
     * @return ContainerInterface[]
     */
    abstract protected function getItems();

    /**
     * @return CallInterface[]
     * @throws \Exception
     */
    public function create()
    {
        $calls = $this->extract();

        foreach ($calls as $key => $call) {
            if (!$this->validate($call)) {
                $this->getGiServiceLocator()->throwInvalidTypeException('Call', $key, 'Web or CLI');
            }
        }

        $calls = array_values($calls);

        $this->setLocalDIToCalls($calls)->setLocalEventManagerToCalls($calls);

        foreach ($this->getItems() as $item) {
            $calls = array_merge($calls, $item->create());
        }

        $this->setRecursiveDIToCalls($calls)->setRecursiveEventManagerToCalls($calls);

        return $calls;
    }

    /**
     * @param mixed $item
     * @return bool
     */
    abstract protected function validate($item);

    /**
     * @param CallInterface[] $calls
     * @return static
     */
    protected function setLocalDIToCalls(array $calls)
    {
        try {
            $this->setDIToCalls($this->getLocalDI(), $calls);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param CallInterface[] $calls
     * @return static
     */
    protected function setRecursiveDIToCalls(array $calls)
    {
        try {
            $this->setDIToCalls($this->getRecursiveDI(), $calls);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param DIInterface $di
     * @param CallInterface[] $calls
     * @return static
     */
    protected function setDIToCalls(DIInterface $di, array $calls)
    {
        foreach ($calls as $call) {
            try {
                $call->setDiIfNotSet($di);
            } catch (\Exception $e) {}
        }

        return $this;
    }

    /**
     * @param CallInterface[] $calls
     * @return static
     */
    protected function setLocalEventManagerToCalls(array $calls)
    {
        try {
            $this->setEventManagerToCalls($this->getLocalEventManager(), $calls);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param CallInterface[] $calls
     * @return static
     */
    protected function setRecursiveEventManagerToCalls(array $calls)
    {
        try {
            $this->setEventManagerToCalls($this->getRecursiveEventManager(), $calls);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param EventManagerInterface $eventManager
     * @param CallInterface[] $calls
     * @return static
     */
    protected function setEventManagerToCalls(EventManagerInterface $eventManager, array $calls)
    {
        foreach ($calls as $call) {
            try {
                $call->setEventManagerIfNotSet($eventManager);
            } catch (\Exception $e) {}
        }

        return $this;
    }
}