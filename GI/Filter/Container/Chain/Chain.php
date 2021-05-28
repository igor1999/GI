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
namespace GI\Filter\Container\Chain;

use GI\Filter\Container\AbstractContainer;

use GI\Filter\Container\ContainerTrait;

use GI\Filter\FilterInterface;

class Chain extends AbstractContainer implements ChainInterface
{
    use ContainerTrait;


    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return isset($this->items[$index]);
    }

    /**
     * @param int $index
     * @return FilterInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->getGiServiceLocator()->throwNotInScopeException($index);
        }

        return $this->items[$index];
    }

    /**
     * @param string|int $index
     * @return FilterInterface
     * @throws \Exception
     */
    protected function _get($index)
    {
        return $this->get($index);
    }

    /**
     * @param FilterInterface $filter
     * @return static
     */
    public function add(FilterInterface $filter)
    {
        $this->items[] = $filter;

        return $this;
    }

    /**
     * @param string|int $index
     * @param FilterInterface $filter
     * @return static
     */
    protected function _set($index, FilterInterface $filter)
    {
        $this->insert($index, $filter);

        return $this;
    }

    /**
     * @param int $key
     * @param FilterInterface $filter
     * @return static
     */
    protected function set(int $key, FilterInterface $filter)
    {
        $this->insert($key, $filter);

        return $this;
    }

    /**
     * @param int $index
     * @param FilterInterface $filter
     * @return bool
     */
    public function insert(int $index, FilterInterface $filter)
    {
        if ($inserted = $this->has($index)) {
            array_splice($this->items, $index, 0, [$filter]);
        } else {
            $this->add($filter);
        }

        return $inserted;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index)
    {
        if ($result = $this->has($index)) {
            array_splice($this->items, $index, 1);
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $data = $this->getInput();

        foreach ($this->items as $item) {
            $data = $item->setInput($data)->execute();
        }

        return $data;
    }
}