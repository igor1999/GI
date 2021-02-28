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
use GI\Storage\Tree\Tree;

use GI\SessionExchange\BaseInterface\Aware\CacheClassAwareInterface;
use GI\SessionExchange\BaseInterface\Aware\SessionExchangeAwareInterface;
use GI\SessionExchange\BaseInterface\CacheClassInterface;

class ClassMeta extends Base implements ClassMetaInterface
{
    const CACHE_PROPERTY     = 'sessionCache';

    const CACHE_CLASS_GETTER = 'getSessionCacheClass';


    /**
     * @var string
     */
    private $cacheClass = '';


    /**
     * ClassMeta constructor.
     * @param string $class
     * @throws \Exception
     */
    public function __construct(string $class)
    {
        parent::__construct($class);

        if (!is_a($this->getName(), SessionExchangeAwareInterface::class, true)) {
            trigger_error(
                'Class is not instance of SessionExchangeAwareInterface: ' . $this->getName(),
                E_USER_ERROR
            );
        }

        if (!$this->getProperties()->has(static::CACHE_PROPERTY)) {
            trigger_error('Cache property not found: ' . static::CACHE_PROPERTY, E_USER_ERROR);
        }

        if (is_a($this->getName(), CacheClassAwareInterface::class, true)) {
            $this->cacheClass = $this->getMethods()->get(static::CACHE_CLASS_GETTER)->execute();

            if (!is_a($this->cacheClass, CacheClassInterface::class, true)) {
                trigger_error(
                    'Class cache is not instance of CacheClassInterface: ' . $this->cacheClass,
                    E_USER_ERROR
                );
            }
        }
    }

    /**
     * @return CacheClassInterface
     */
    protected function getCacheClass()
    {
        return $this->cacheClass;
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
            $cacheClass = $this->cacheClass;
            $cache = is_a($this->cacheClass, CacheClassInterface::class, true)
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
        return (empty($this->cacheClass) && ($cache instanceof CacheClassInterface))
            || (!empty($this->cacheClass) && is_a($cache, $this->cacheClass, true));
    }
}