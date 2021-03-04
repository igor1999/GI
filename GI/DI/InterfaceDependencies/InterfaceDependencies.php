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
namespace GI\DI\InterfaceDependencies;

use GI\DI\Dependency\Dependency;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\DI\Exception\ExceptionAwareTrait;

use GI\DI\Dependency\DependencyInterface;

class InterfaceDependencies implements InterfaceDependenciesInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    /**
     * @var string
     */
    private $interface = '';

    /**
     * @var DependencyInterface
     */
    private $noCaller;

    /**
     * @var DependencyInterface[]
     */
    private $items = [];


    /**
     * InterfaceDependencies constructor.
     * @param string $interface
     */
    public function __construct(string $interface)
    {
        $this->interface = $interface;
    }

    /**
     * @return string
     */
    protected function getInterface()
    {
        return $this->interface;
    }

    /**
     * @param mixed $source
     * @param bool $cached
     * @param bool $forCallerInherits
     * @return Dependency
     */
    protected function createDependency($source, bool $cached = false, bool $forCallerInherits = false)
    {
        return new Dependency($source, $cached, $forCallerInherits);
    }

    /**
     * @return bool
     */
    public function hasNoCaller()
    {
        return $this->noCaller instanceof DependencyInterface;
    }

    /**
     * @return DependencyInterface
     * @throws \Exception
     */
    public function getNoCaller()
    {
        if (!$this->hasNoCaller()) {
            $this->throwDependencyNotFoundException($this->interface);
        }

        return $this->noCaller;
    }

    /**
     * @param mixed $source
     * @param bool $cached
     * @param bool $forCallerInherits
     * @return static
     */
    protected function createNoCaller($source, bool $cached = false, bool $forCallerInherits = false)
    {
        $this->noCaller = $this->createDependency($source, $cached, $forCallerInherits);

        return $this;
    }

    /**
     * @return static
     */
    protected function removeNoCaller()
    {
        $this->noCaller = null;

        return $this;
    }

    /**
     * @param string $caller
     * @return bool
     */
    public function has(string $caller)
    {
        return isset($this->items[$caller]);
    }

    /**
     * @param string|null $caller
     * @return DependencyInterface
     * @throws \Exception
     */
    public function get(string $caller)
    {
        if (!$this->has($caller)) {
            $this->throwDependencyNotFoundException($this->interface, $caller);
        }

        return $this->items[$caller];
    }

    /**
     * @return DependencyInterface[]
     */
    public function getItems()
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
     * @param string|null $caller
     * @return DependencyInterface
     * @throws \Exception
     */
    public function find(string $caller = null)
    {
        if (empty($caller)) {
            $result = $this->getNoCaller();
        } else {
            try {
                $result = $this->get($caller);
            } catch (\Exception $exception) {
                try {
                    $result = $this->get($this->findAncestor($caller));
                } catch (\Exception $exception) {
                    $result = $this->getNoCaller();
                }
            }
        }

        return $result;
    }

    /**
     * @param string $caller
     * @return string
     * @throws \Exception
     */
    protected function findAncestor(string $caller)
    {
        $f = function(DependencyInterface $item)
        {
            return $item->isForCallerInherits();
        };
        $callers = array_keys(array_filter($this->getItems(), $f));

        $ancestors = $this->giGetClassMeta($caller)->getParents()->getOrderedAncestors($callers);

        return $ancestors->getFirst()->getName();
    }

    /**
     * @param string|null $caller
     * @param mixed|string $source
     * @param bool $cached
     * @param bool $forCallerInherits
     * @return static
     */
    public function create(string $caller = null, $source = null, bool $cached = false, bool $forCallerInherits = false)
    {
        if (empty($caller)) {
            $this->createNoCaller($source, $cached, $forCallerInherits);
        } else {
            $this->items[$caller] = $this->createDependency($source, $cached, $forCallerInherits);
        }

        return $this;
    }

    /**
     * @param string|null $caller
     * @return bool
     */
    public function remove(string $caller = null)
    {
        if (empty($caller)) {
            $this->removeNoCaller();

            $result = true;
        } elseif ($result = $this->has($caller)) {
            unset($this->items[$caller]);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->removeNoCaller();

        $this->items = [];

        return $this;
    }
}