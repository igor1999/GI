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
namespace GI\DI;

use GI\DI\InterfaceDependencies\InterfaceDependencies;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\DI\Exception\ExceptionAwareTrait;

use GI\DI\InterfaceDependencies\InterfaceDependenciesInterface;

class DI implements DIInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    /**
     * @var InterfaceDependenciesInterface[]
     */
    private $items = [];


    /**
     * @param string $interface
     * @return bool
     */
    public function has(string $interface)
    {
        return isset($this->items[$interface]);
    }

    /**
     * @param string $interface
     * @return InterfaceDependenciesInterface
     * @throws \Exception
     */
    protected function get(string $interface)
    {
        if (!$this->has($interface)) {
            $this->throwDependencyNotFoundException($interface);
        }

        return $this->items[$interface];
    }

    /**
     * @return InterfaceDependenciesInterface[]
     */
    protected function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param string $interface
     * @param string |null $caller
     * @param mixed|null $default
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function find(string $interface, string $caller = null, $default = null, array $params = [])
    {
        try {
            $result = $this->get($interface)->find($caller)->getInstance($params);
        } catch (\Exception $exception) {
            if (empty($default)) {
                throw $exception;
            } elseif (!is_a($default, $interface, true)) {
                trigger_error('Default param should to implement pattern', E_USER_ERROR);
            } elseif (is_object($default)) {
                $result = $default;
            } elseif (is_string($default)) {
                $result = $this->getGiServiceLocator()->getClassMeta($default)->create($params);
            } else {
                trigger_error('Default param should be a class name or instance', E_USER_ERROR);
            }
        }

        return $result;
    }

    /**
     * @param string $interface
     * @param string|null $caller
     * @param mixed|null $source
     * @param bool $cached
     * @param bool $forCallerInherits
     * @return static
     */
    protected function create(
        string $interface, string $caller = null, $source = null, bool $cached = false, bool $forCallerInherits = true)
    {
        if (!is_a($source, $interface, true)) {
            trigger_error('Source should to implement pattern', E_USER_ERROR);
        }

        if (!$this->has($interface)) {
            $this->items[$interface] = $this->createInterfaceDependencies($interface);
        }

        $this->items[$interface]->create($caller, $source, $cached, $forCallerInherits);

        return $this;
    }

    /**
     * @param string $interface
     * @return InterfaceDependencies
     */
    protected function createInterfaceDependencies(string $interface)
    {
        return new InterfaceDependencies($interface);
    }

    /**
     * @param string $interface
     * @return bool
     */
    protected function remove(string $interface)
    {
        if ($result = $this->has($interface)) {
            unset($this->items[$interface]);
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function clean()
    {
        $this->items = [];

        return $this;
    }
}