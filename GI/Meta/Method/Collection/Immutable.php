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
namespace GI\Meta\Method\Collection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\Method\MethodInterface;
use GI\Pattern\ArrayExchange\ExtractionInterface;

class Immutable implements ImmutableInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var MethodInterface[]
     */
    private $items = [];


    /**
     * Immutable constructor.
     * @param MethodInterface[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->_set($item);
        }
    }

    /**
     * @param string $method
     * @return bool
     */
    public function has(string $method)
    {
        return isset($this->items[$method]);
    }

    /**
     * @param string $method
     * @return MethodInterface
     * @throws \Exception
     */
    public function get(string $method)
    {
        if (!$this->has($method)) {
            $this->getGiServiceLocator()->throwNotInScopeException($method);
        }

        return $this->items[$method];
    }

    /**
     * @return MethodInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        reset($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return MethodInterface
     * @throws \Exception
     */
    public function getLast()
    {
        end($this->items);

        return $this->get((string)key($this->items));
    }

    /**
     * @return MethodInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return bool
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
     * @param \Closure $closure
     * @return MethodInterface[]
     */
    public function filter(\Closure $closure)
    {
        return array_filter($this->items, $closure);
    }

    /**
     * @param string $descriptor
     * @return MethodInterface[]
     */
    public function findByDescriptorName(string $descriptor)
    {
        $f = function (MethodInterface $method) use ($descriptor) {
            return $method->hasDescriptor($descriptor);
        };

        return $this->filter($f);
    }

    /**
     * @param string $descriptor
     * @return MethodInterface
     * @throws \Exception
     */
    public function findOneByDescriptorName(string $descriptor)
    {
        $items = $this->findByDescriptorName($descriptor);

        if (empty($items)) {
            $this->getGiServiceLocator()->throwNotFoundException('Method with descriptor', [$descriptor]);
        }

        return array_shift($items);
    }

    /**
     * @param string $descriptor
     * @param mixed $value
     * @return MethodInterface[]
     */
    public function findByDescriptorValue(string $descriptor, $value)
    {
        $f = function (MethodInterface $method) use ($descriptor, $value) {
            return $method->hasDescriptor($descriptor) && ($method->getDescriptor($descriptor) == $value);
        };

        return $this->filter($f);
    }

    /**
     * @param string $descriptor
     * @param mixed $value
     * @return MethodInterface
     * @throws \Exception
     */
    public function findOneByDescriptorValue(string $descriptor, $value)
    {
        $items = $this->findByDescriptorValue($descriptor, $value);

        if (empty($items)) {
            $this->getGiServiceLocator()->throwCommonException('Method with descriptor \'%s\' and value \'%s\' not found', [$descriptor, $value]);
        }

        return array_shift($items);
    }

    /**
     * @param MethodInterface $method
     * @return static
     */
    protected function _set(MethodInterface $method)
    {
        $this->items[$method->getName()] = $method;

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function _remove(string $name)
    {
        if ($result = $this->has($name)) {
            unset($this->items[$name]);
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function _clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @param string $property
     * @return bool
     */
    public function hasGetter(string $property)
    {
        return $this->hasCommonGetter($property) || $this->hasBoolGetter($property);
    }

    /**
     * @param string $property
     * @return bool
     */
    protected function hasCommonGetter(string $property)
    {
        $getter = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildGet($property);

        return $this->has($getter);
    }

    /**
     * @param string $property
     * @return bool
     */
    protected function hasBoolGetter(string $property)
    {
        $getter = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildIs($property);

        return $this->has($getter);
    }

    /**
     * @param mixed|null $instance
     * @param string $property
     * @return mixed
     * @throws \Exception
     */
    public function executeGetter($instance, string $property)
    {
        if ($this->hasCommonGetter($property)) {
            $method = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildGet($property);
        } elseif ($this->hasBoolGetter($property)) {
            $method = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildIs($property);
        } else {
            $method = null;
        }

        if (empty($method)) {
            $this->getGiServiceLocator()->throwNotFoundException('Getter for property', $property);
        }

        return $this->get($method)->execute($instance);
    }

    /**
     * @param string $property
     * @return bool
     */
    public function hasSetter(string $property)
    {
        $setter = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildSet($property);

        return $this->has($setter);
    }

    /**
     * @param mixed|null $instance
     * @param string $property
     * @param mixed $value
     * @return static
     * @throws \Exception
     */
    public function executeSetter($instance, string $property, $value)
    {
        $method = $this->getGiServiceLocator()->getUtilites()->getPSRFormatBuilder()->buildSet($property);

        if (!$this->hasSetter($property)) {
            $this->getGiServiceLocator()->throwNotFoundException('Setter', $method);
        }

        $this->get($method)->execute($instance, [$value]);

        return $this;
    }

    /**
     * @param mixed $instance
     * @param string|null $descriptor
     * @return array
     * @throws \Exception
     */
    public function extract($instance, string $descriptor = null)
    {
        if (empty($descriptor)) {
            $descriptor = self::EXTRACTION_DESCRIPTOR;
        }

        $result = [];

        foreach ($this->findByDescriptorName($descriptor) as $method) {
            $name = $method->getName();

            $property = $method->getDescriptor($descriptor);
            if (empty($property)) {
                try {
                    $property = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixesGetAndIs($name);
                } catch (\Exception $exception) {
                    $property = $name;
                }
            }

            $value = $method->execute($instance);
            if ($value instanceof ExtractionInterface) {
                $value = $value->extract();
            }

            $result[$property] = $value;
        }

        return $result;
    }

    /**
     * @param mixed $instance
     * @param array $contents
     * @param string|null $descriptor
     * @return static
     */
    public function hydrate($instance, array $contents, string $descriptor = null)
    {
        if (empty($descriptor)) {
            $descriptor = self::HYDRATION_DESCRIPTOR;
        }

        foreach ($this->findByDescriptorName($descriptor) as $method) {
            $name = $method->getName();

            $key = $method->getDescriptor($descriptor);
            if (empty($key)) {
                try {
                    $key = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixSet($name);
                } catch (\Exception $exception) {}
            }

            if (array_key_exists($key, $contents)) {
                $method->execute($instance, [$contents[$key]]);
            }
        }

        return $this;
    }

    /**
     * @param mixed $instance
     * @param string|null $descriptor
     * @return static
     */
    public function validate($instance, string $descriptor = null)
    {
        if (empty($descriptor)) {
            $descriptor = self::VALIDATION_DESCRIPTOR;
        }

        foreach ($this->findByDescriptorName($descriptor) as $method) {
            $method->execute($instance);
        }

        return $this;
    }

    /**
     * @param mixed $instance
     * @param string $source
     * @param string|null $descriptor
     * @param string|null $placeHolderTemplate
     * @return string
     * @throws \Exception
     */
    public function parse($instance, string $source, string $descriptor = null, string $placeHolderTemplate = null)
    {
        if (empty($descriptor)) {
            $descriptor = self::PARSING_DESCRIPTOR;
        }

        foreach ($this->extract($instance, $descriptor) as $key => $value) {
            $placeholder = sprintf($placeHolderTemplate, $key);

            $source = str_replace($placeholder, $value, $source);
        }

        return $source;
    }
}