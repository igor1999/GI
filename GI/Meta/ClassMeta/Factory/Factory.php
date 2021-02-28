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
namespace GI\Meta\ClassMeta\Factory;

use GI\Meta\ClassMeta\ClassMeta;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\ClassMeta\ClassMetaInterface;

class Factory implements FactoryInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ClassMetaInterface[]
     */
    private $items = [];


    /**
     * @param mixed $source
     * @return string
     */
    protected function createClassName($source)
    {
        if (is_object($source)) {
            $class = get_class($source);
        } elseif (is_string($source)) {
            $class = $source;
        } else {
            $class = '';
        }

        return $class;
    }

    /**
     * @param mixed $source
     * @return bool
     */
    public function has($source)
    {
        $class = $this->createClassName($source);

        return isset($this->items[$class]);
    }

    /**
     * @param mixed $source
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function get($source)
    {
        $class = $this->createClassName($source);

        if (!$this->has($class)) {
            $this->items[$class] = $this->createClassContainer($class);
        }

        return $this->items[$class];
    }

    /**
     * @param string $class
     * @return ClassMeta
     * @throws \Exception
     */
    protected function createClassContainer(string $class)
    {
        return new ClassMeta($class);
    }
}