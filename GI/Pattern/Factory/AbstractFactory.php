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
namespace GI\Pattern\Factory;

use GI\Pattern\Factory\ClassContainer\Container;
use GI\Pattern\Factory\TemplateClasses\TemplateClasses;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Pattern\Factory\ClassContainer\ContainerInterface;
use GI\Util\TextProcessing\PSRFormat\PrefixInterface as PSRFormatPrefixInterface;
use GI\Pattern\Factory\TemplateClasses\TemplateClassesInterface;

abstract class AbstractFactory implements FactoryInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ContainerInterface[]
     */
    private $items = [];

    /**
     * @var bool|\Closure
     */
    private $cached = false;

    /**
     * @var string
     */
    private $prefix = PSRFormatPrefixInterface::PREFIX_CREATE;

    /**
     * @var TemplateClassesInterface
     */
    private $templateClasses;


    /**
     * @return bool|\Closure
     */
    public function isCached()
    {
        return $this->cached;
    }

    /**
     * @param bool|\Closure $cached
     * @return static
     */
    protected function setCached($cached)
    {
        $this->cached = ($cached instanceof \Closure) ? $cached : (bool)$cached;

        return $this;
    }

    /**
     * @return TemplateClassesInterface
     */
    protected function getTemplateClasses()
    {
        if (!($this->templateClasses instanceof TemplateClassesInterface)) {
            $this->templateClasses = new TemplateClasses();
        }

        return $this->templateClasses;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @return ContainerInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->getGiServiceLocator()->throwNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @return ContainerInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param string $class
     * @param \Closure|bool|null $cached
     * @param bool $validateClass
     * @return static
     * @throws \Exception
     */
    protected function set(string $class, $cached = null, bool $validateClass = true)
    {
        if ($validateClass) {
            $this->getTemplateClasses()->validate($class);
        }

        if (!is_bool($cached) && !($cached instanceof \Closure)) {
            $cached = $this->cached;
        }

        $container = $this->createContainer($class, $cached);

        $this->items[$container->getShortName()] = $container;

        return $this;
    }

    /**
     * @param string $key
     * @param string $class
     * @param \Closure|bool|null $cached
     * @param bool $validateClass
     * @return static
     * @throws \Exception
     */
    protected function setNamed(string $key, string $class, $cached = null, bool $validateClass = true)
    {
        if ($validateClass) {
            $this->getTemplateClasses()->validate($class);
        }

        if (!is_bool($cached) && !($cached instanceof \Closure)) {
            $cached = $this->cached;
        }

        $this->items[$key] = $this->createContainer($class, $cached);

        return $this;
    }

    /**
     * @param string $class
     * @param \Closure|bool|null $cached
     * @return Container
     */
    protected function createContainer(string $class, $cached)
    {
        return new Container($class, $cached);
    }

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return static
     */
    protected function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return static
     */
    protected function setPrefixToCreate()
    {
        $this->setPrefix(PSRFormatPrefixInterface::PREFIX_CREATE);

        return $this;
    }

    /**
     * @return static
     */
    protected function setPrefixToGet()
    {
        $this->setPrefix(PSRFormatPrefixInterface::PREFIX_GET);

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @param string $prefix
     * @return mixed
     * @throws \Exception
     */
    public function create(string $method, array $arguments = [], string $prefix = '')
    {
        if (empty($prefix)) {
            $prefix = $this->getPrefix();
        }

        try {
            $key = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseAfterPrefix($method, $prefix, false);
        } catch (\Exception $exception) {
            $key = null;
            $this->getGiServiceLocator()->throwMagicMethodException($method);
        }

        return $this->get($key)->get($arguments);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        return $this->create($method, $arguments);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixGet(string $method, array $arguments = [])
    {
        return $this->create($method, $arguments, PSRFormatPrefixInterface::PREFIX_GET);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixSet(string $method, array $arguments = [])
    {
        return $this->create($method, $arguments, PSRFormatPrefixInterface::PREFIX_SET);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixAdd(string $method, array $arguments = [])
    {
        return $this->create($method, $arguments, PSRFormatPrefixInterface::PREFIX_ADD);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixInsert(string $method, array $arguments = [])
    {
        return $this->create($method, $arguments, PSRFormatPrefixInterface::PREFIX_INSERT);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function createWithPrefixCreate(string $method, array $arguments = [])
    {
        return $this->create($method, $arguments, PSRFormatPrefixInterface::PREFIX_CREATE);
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function remove(string $key)
    {
        if ($result = $this->has($key)) {
            unset($this->items[$key]);
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