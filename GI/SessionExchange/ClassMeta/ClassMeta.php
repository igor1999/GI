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
namespace GI\SessionExchange\ClassMeta;

use GI\Meta\ClassMeta\ClassMeta as Base;
use GI\SessionExchange\BaseInterface\Aware\CacheInterfaceAwareInterface;
use GI\Storage\Tree\Tree;

use GI\SessionExchange\BaseInterface\Aware\CacheClassAwareInterface;
use GI\SessionExchange\BaseInterface\Aware\SessionExchangeAwareInterface;
use GI\SessionExchange\BaseInterface\CacheClassInterface;

class ClassMeta extends Base implements ClassMetaInterface
{
    const CACHE_PROPERTY                  = 'sessionCache';

    const DEFAULT_CACHE_CLASS_GETTER      = 'getDefaultSessionCacheClass';

    const POSSIBLE_CACHE_INTERFACE_GETTER = 'getPossibleSessionCacheInterface';


    /**
     * @var string
     */
    private $defaultCacheClass = '';

    /**
     * @var string
     */
    private $possibleCacheInterface = '';


    /**
     * ClassMeta constructor.
     * @param string $class
     * @throws \Exception
     */
    public function __construct(string $class)
    {
        parent::__construct($class);

        if (is_a($this->getName(), CacheClassAwareInterface::class, true)) {
            $this->defaultCacheClass = $this->getMethods()->get(static::DEFAULT_CACHE_CLASS_GETTER)->execute();
        }

        if (is_a($this->getName(), CacheInterfaceAwareInterface::class, true)) {
            $this->possibleCacheInterface = $this->getMethods()
                ->get(static::POSSIBLE_CACHE_INTERFACE_GETTER)
                ->execute();
        } else {
            $this->possibleCacheInterface = $this->defaultCacheClass;
        }

        $this->validateClass()->validateProperty()->validateDefaultCacheClass()->validatePossibleCacheInterface();
    }

    /**
     * @return static
     */
    protected function validateClass()
    {
        if (!is_a($this->getName(), SessionExchangeAwareInterface::class, true)) {
            trigger_error(
                'Class is not instance of SessionExchangeAwareInterface: ' . $this->getName(),
                E_USER_ERROR
            );
        }

        return $this;
    }

    /**
     * @return static
     */
    protected function validateProperty()
    {
        if (!$this->getProperties()->has(static::CACHE_PROPERTY)) {
            trigger_error('Cache property not found: ' . static::CACHE_PROPERTY, E_USER_ERROR);
        }

        return $this;
    }

    /**
     * @return static
     */
    protected function validateDefaultCacheClass()
    {
        if (!is_a($this->defaultCacheClass, CacheClassInterface::class, true)) {
            trigger_error(
                'Default class cache is not instance of CacheClassInterface: ' . $this->defaultCacheClass,
                E_USER_ERROR
            );
        }

        return $this;
    }

    /**
     * @return static
     */
    protected function validatePossibleCacheInterface()
    {
        if (!is_a($this->possibleCacheInterface, CacheClassInterface::class, true)) {
            trigger_error(
                'Possible class cache is not instance of CacheClassInterface: '
                . $this->possibleCacheInterface,
                E_USER_ERROR
            );
        }

        return $this;
    }

    /**
     * @return CacheClassInterface
     */
    protected function getDefaultCacheClass()
    {
        return $this->defaultCacheClass;
    }

    /**
     * @return string
     */
    protected function getPossibleCacheInterface()
    {
        return $this->possibleCacheInterface;
    }

    /**
     * @param string $data
     * @return static
     * @throws \Exception
     */
    public function load(string $data)
    {
        $cache = @unserialize($data);

        if (!$this->checkCacheType($cache)) {
            $cacheClass = $this->defaultCacheClass;
            $cache = is_a($this->defaultCacheClass, CacheClassInterface::class, true)
                ? new $cacheClass()
                : $this->createDefaultCache();
        }

        $this->getProperties()->get(static::CACHE_PROPERTY)->setValue(null, $cache);

        return $this;
    }

    /**
     * @return Tree
     */
    protected function createDefaultCache()
    {
        return new Tree();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function save()
    {
        $cache = $this->getProperties()->get(static::CACHE_PROPERTY)->getValue();

        return $this->checkCacheType($cache) ? serialize($cache) : '';
    }

    /**
     * @param mixed $cache
     * @return bool
     */
    protected function checkCacheType($cache)
    {
        return (empty($this->possibleCacheInterface) && ($cache instanceof CacheClassInterface))
            || (!empty($this->possibleCacheInterface) && is_a($cache, $this->possibleCacheInterface, true));
    }
}