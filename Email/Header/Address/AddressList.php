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
namespace GI\Email\Header\Address;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class AddressList implements AddressListInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var AddressInterface[]
     */
    private $items = [];

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return array_key_exists($index, $this->items);
    }

    /**
     * @param int $index
     * @return AddressInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->giThrowNotInScopeException($index);
        }

        return $this->items[$index];
    }

    /**
     * @return AddressInterface[]
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
     * @param AddressInterface $item
     * @return static
     */
    public function add(AddressInterface $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param string $email
     * @param string $name
     * @return static
     * @throws \Exception
     */
    public function createAndAdd(string $email, string $name = '')
    {
        $this->add($this->createAddress($email, $name));

        return $this;
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return AddressInterface
     * @throws \Exception
     */
    protected function createAddress(string $email, string $name)
    {
        try {
            $result = $this->giGetDi(AddressInterface::class, null, [$email, $name]);
        } catch (\Exception $e) {
            $result = new Address($email, $name);
        }

        return $result;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index)
    {
        $result = $this->has($index);

        if ($result) {
            array_splice($this->items, $index, 1);
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
     * @return static
     * @throws \Exception
     */
    public function validateIfNotEmpty()
    {
        if ($this->isEmpty()) {
            $this->giThrowIsEmptyException('Address list');
        }

        return $this;
    }

    /**
     * @return array
     */
    public function extract()
    {
        $f = function(Address $item)
        {
            return $item->toString();
        };

        return array_map($f, $this->items);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return implode(self::SEPARATOR, $this->extract());
    }
}