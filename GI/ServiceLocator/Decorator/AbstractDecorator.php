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
     * @var string
     */
    private $caller;


    /**
     * AbstractDecorator constructor.
     * @param string $caller
     */
    public function __construct(string $caller)
    {
        $this->caller = $caller;
    }

    /**
     * @return string
     */
    public function getCaller()
    {
        return $this->caller;
    }

    /**
     * @param string $caller
     * @return static
     */
    protected function setCaller(string $caller)
    {
        $this->caller = $caller;

        return $this;
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
            $result = call_user_func([$serviceLocator, $method], $this->caller);
        } else {
            $result = null;
            die('Method ' . $method . ' of class ' . get_class($serviceLocator) . ' not found');
        }

        return $result;
    }
}