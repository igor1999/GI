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
namespace GI\Pattern\Factory\ClassContainer;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Container implements ContainerInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var array
     */
    private $cache = [];

    /**
     * @var string
     */
    private $class = '';

    /**
     * @var bool|\Closure
     */
    private $cached = false;


    /**
     * ClassContainer constructor.
     * @param string $class
     * @param bool|\Closure $cached
     */
    public function __construct(string $class, $cached = false)
    {
        $this->class  = $class;
        $this->cached = $cached;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return bool|\Closure
     */
    public function isCached()
    {
        return $this->cached;
    }

    /**
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function get(array $arguments)
    {
        if (!$this->cached) {
            $result = $this->create($arguments);
        } else {
            if ($this->cached instanceof \Closure) {
                $key = call_user_func_array($this->cached, $arguments);
            } else {
                $key = empty($arguments) ? 0 : serialize($arguments);
            }

            if (!isset($this->cache[$key])) {
                $this->cache[$key] = $this->create($arguments);
            }

            $result = $this->cache[$key];
        }

        return $result;
    }

    /**
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    protected function create(array $arguments)
    {
        return $this->giGetClassMeta($this->class)->create($arguments);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getShortName()
    {
        return $this->giGetClassMeta($this->class)->getShortName();
    }
}