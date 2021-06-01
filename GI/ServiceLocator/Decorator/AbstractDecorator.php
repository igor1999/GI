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
namespace GI\ServiceLocator\Decorator;

abstract class AbstractDecorator implements DecoratorInterface
{
    /**
     * @var mixed
     */
    private $caller;


    /**
     * AbstractDecorator constructor.
     * @param mixed $caller
     */
    public function __construct($caller)
    {
        $this->caller = $caller;
    }

    /**
     * @return mixed
     */
    public function getCaller()
    {
        return $this->caller;
    }

    /**
     * @param mixed $caller
     * @return static
     */
    protected function setCaller($caller)
    {
        $this->caller = $caller;

        return $this;
    }

    /**
     * @return string
     */
    protected function getCallerClass()
    {
        return get_class($this->getCaller());
    }

    /**
     * @return mixed
     */
    abstract protected function getServiceLocator();

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments = [])
    {
        $serviceLocator = $this->getServiceLocator();

        if (method_exists($serviceLocator, $method)) {
            $result = call_user_func([$serviceLocator, $method], $this->getCallerClass());
        } else {
            $result = null;
            die('Method ' . $method . ' of class ' . get_class($serviceLocator) . ' not found');
        }

        return $result;
    }
}