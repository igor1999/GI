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
namespace GI\Component\Base\View\Relations;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Component\Base\View\ClientAttributes\ClientAttributesInterface;

class Relations implements RelationsInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ClientAttributesInterface
     */
    private $owner;

    /**
     * @var ClientAttributesInterface[]
     */
    private $items = [];


    /**
     * Relations constructor.
     * @param ClientAttributesInterface $owner
     */
    public function __construct(ClientAttributesInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return ClientAttributesInterface
     */
    protected function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param string $key
     * @return ClientAttributesInterface
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @return ClientAttributesInterface[]
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
     * @return int
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param string $key
     * @param ClientAttributesInterface $item
     * @return static
     * @throws \Exception
     */
    public function set(string $key, ClientAttributesInterface $item)
    {
        $this->items[$key] = $item;

        return $this;
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
     * @return static
     */
    public function clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $container = $this->giGetDOMFactory()->createContainerElement();

        foreach ($this->getItems() as $key => $item) {
            $hidden = $this->getOwner()->createRelationHidden($key, $item);
            $container->getChildNodes()->add($hidden);
        }

        return $container->toString();
    }
}