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
namespace GI\DI\Dependency;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Dependency implements DependencyInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var mixed|string
     */
    private $source;

    /**
     * @var bool
     */
    private $cached = false;

    /**
     * @var bool
     */
    private $forCallerInherits = false;

    /**
     * @var mixed[]
     */
    private $cache = [];


    /**
     * Item constructor.
     * @param mixed $source
     * @param bool $cached
     * @param bool $forCallerInherits
     */
    public function __construct($source, bool $cached = false, bool $forCallerInherits = false)
    {
        $this->source            = $source;
        $this->cached            = $cached;
        $this->forCallerInherits = $forCallerInherits;
    }

    /**
     * @return mixed|string
     */
    protected function getSource()
    {
        return $this->source;
    }

    /**
     * @return bool
     */
    protected function isCached()
    {
        return $this->cached;
    }

    /**
     * @return bool
     */
    public function isForCallerInherits()
    {
        return $this->forCallerInherits;
    }

    /**
     * @return array
     */
    protected function getCache()
    {
        return $this->cache;
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function getInstance(array $params = [])
    {
        if ($this->cached) {
            $key = empty($params) ? 0 : serialize($params);

            if (!isset($this->cache[$key])) {
                $this->cache[$key] = $this->create($params);
            }

            $result = $this->cache[$key];
        } else {
            $result = $this->create($params);
        }

        return $result;
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    protected function create(array $params = [])
    {
        if (is_string($this->source)) {
            $result = $this->getGiServiceLocator()->getClassMeta($this->source)->create($params);
        } else {
            $result = $this->source;
        }

        return $result;
    }
}