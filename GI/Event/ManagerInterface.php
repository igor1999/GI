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

use GI\Pattern\Closing\ClosingInterface;
use GI\Storage\Collection\ClosureCollection\ArrayList\Closable\ClosableInterface as HandlersInterface;

interface ManagerInterface extends  ClosingInterface
{
    /**
     * @param string $event
     * @param \Closure $handler
     * @return static
     * @throws \Exception
     */
    public function attach(string $event, \Closure $handler);

    /**
     * @param ManagerInterface $manager
     * @return static
     * @throws \Exception
     */
    public function merge(ManagerInterface $manager);

    /**
     * @param string $event
     * @return bool
     */
    public function has(string $event);

    /**
     * @param string $event
     * @return HandlersInterface
     * @throws \Exception
     */
    public function get(string $event);

    /**
     * @return HandlersInterface[]
     */
    public function getEvents();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param string $event
     * @return bool
     * @throws \Exception
     */
    public function remove(string $event);

    /**
     * @return static
     * @throws \Exception
     */
    public function clean();

    /**
     * @param string $event
     * @param array $params
     * @return array
     */
    public function fire(string $event, array $params = []);
}