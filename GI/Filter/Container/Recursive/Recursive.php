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
namespace GI\Filter\Container\Recursive;

use GI\Filter\Container\AbstractContainer;

use GI\Filter\Container\ContainerTrait;

use GI\Filter\FilterInterface;

class Recursive extends AbstractContainer implements RecursiveInterface
{
    use ContainerTrait;


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
     * @return FilterInterface
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
     * @param string|int $key
     * @return FilterInterface
     * @throws \Exception
     */
    protected function _get($key)
    {
        return $this->get($key);
    }

    /**
     * @param string $key
     * @param FilterInterface $filter
     * @return static
     */
    public function set(string $key, FilterInterface $filter)
    {
        $this->items[$key] = $filter;

        return $this;
    }

    /**
     * @param string|int $key
     * @param FilterInterface $filter
     * @return static
     */
    protected function _set($key, FilterInterface $filter)
    {
        return $this->set($key, $filter);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key)
    {
        if ($result = $this->has($key)) {
            unset($this->items[$key]);
        }

        return $result;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function execute()
    {
        if (!is_array($this->getInput()) && !is_object($this->getInput())) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Filter input', $this->getInput(), 'array or object');
        }

        return is_array($this->getInput()) ? $this->executeForArray() : $this->executeForObject();
    }

    /**
     * @return mixed
     */
    protected function executeForArray()
    {
        $result = $this->getInput();
        foreach ($result as $key => $value) {
            try {
                $result[$key] = $this->get($key)->setInput($value)->execute();
            } catch (\Exception $e) {}
        }

        return $result;
    }
    /**
     * @return mixed
     * @throws \Exception
     */
    protected function executeForObject()
    {
        $methodReflectionList = $this->getGiServiceLocator()->getClassMeta($this->getInput())->getMethods();

        foreach ($this->getItems() as $key => $item) {
            if ($methodReflectionList->hasGetter($key)) {
                $value = $methodReflectionList->executeGetter($this->getInput(), $key);
                $value = $item->setInput($value)->execute();
                $methodReflectionList->executeSetter($this->getInput(), $key, $value);
            }
        }

        return $this->getInput();
    }
}