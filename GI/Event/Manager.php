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
namespace GI\Event;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Closing\ClosingTrait;

use GI\Storage\Collection\ClosureCollection\ArrayList\Closable\ClosableInterface as HandlersInterface;

class Manager implements ManagerInterface
{
    use ServiceLocatorAwareTrait, ClosingTrait;


    /**
     * @var HandlersInterface[]
     */
    private $events = [];


    /**
     * @param string $event
     * @param \Closure $handler
     * @return static
     * @throws \Exception
     */
    public function attach(string $event, \Closure $handler)
    {
        $this->validateClosing();

        if (!$this->has($event)) {
            $this->events[$event] = $this->giGetStorageFactory()->createClosureArrayListClosable();
        }

        $this->events[$event]->add($handler);

        return $this;
    }

    /**
     * @param ManagerInterface $manager
     * @return static
     * @throws \Exception
     */
    public function merge(ManagerInterface $manager)
    {
        foreach ($manager->getEvents() as $event => $handlers) {
            foreach ($handlers->getItems() as $handler) {
                $this->attach($event, $handler);
            }
        }

        return $this;
    }

    /**
     * @param string $event
     * @return bool
     */
    public function has(string $event)
    {
        return isset($this->events[$event]);
    }

    /**
     * @param string $event
     * @return HandlersInterface
     * @throws \Exception
     */
    public function get(string $event)
    {
        if (!$this->has($event)) {
            $this->giThrowNotInScopeException($event);
        }

        return $this->events[$event];
    }

    /**
     * @return HandlersInterface[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->events);
    }

    /**
     * @param string $event
     * @return bool
     * @throws \Exception
     */
    public function remove(string $event)
    {
        $this->validateClosing();

        $result = $this->has($event);

        if ($result) {
            unset($this->events[$event]);
        }

        return $result;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function clean()
    {
        $this->validateClosing();

        $this->events = [];

        return $this;
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->setClosed(true);

        foreach ($this->events as $handlers) {
            $handlers->close();
        }

        return $this;
    }

    /**
     * @param string $event
     * @param array $params
     * @return array
     */
    public function fire(string $event, array $params = [])
    {
        try {
            $result = $this->get($event)->executeParallel($params);
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }
}