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
namespace GI\RDB\Meta\Table;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Driver\DriverInterface;

class TableList implements TableListInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var TableInterface[]
     */
    private $items = [];


    /**
     * TableList constructor.
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;

        foreach ($this->driver->fetchTableList() as $name) {
            $this->items[$name] = null;
        }
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name)
    {
        return array_key_exists($name, $this->items);
    }

    /**
     * @param string $name
     * @return TableInterface
     * @throws \Exception
     */
    public function get(string $name)
    {
        if (!$this->has($name)) {
            $this->giThrowNotInScopeException($name);
        }

        if (!($this->items[$name]) instanceof TableInterface) {
            $this->items[$name] = $this->giGetDi(
                TableInterface::class, new Table($this->getDriver(), $name), [$this->getDriver(), $name]
            );
        }

        return $this->items[$name];
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return TableInterface
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $name = $this->giGetPSRFormatParser()->parseWithPrefixGet($method);
        } catch (\Exception $exception) {
            $name = null;
            $this->giThrowMagicMethodException($method);
        }

        $name = str_replace('_', '.', $name);
        $name = $this->giGetCamelCaseConverter()->convertToUnderlineLowerCase($name);
        $name = str_replace('._', '.', $name);

        return $this->get($name);
    }

    /**
     * @return TableInterface[]
     * @throws \Exception
     */
    public function getItems()
    {
        foreach ($this->items as $name => $table) {
            $this->get($name);
        }

        return $this->items;
    }

    /**
     * @param string $schema
     * @return TableInterface[]
     * @throws \Exception
     */
    public function getSchemaItems(string $schema)
    {
        $f = function(Table $item) use ($schema)
        {
            return $item->getSchema() == $schema;
        };

        return array_filter($this->getItems(), $f);
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
     * @param string $namePart
     * @return TableInterface[]
     * @throws \Exception
     */
    public function find(string $namePart)
    {
        $result = [];

        foreach ($this->items as  $name => $table) {
            if (strpos($name, $namePart) !== false) {
                $result[$name] = $this->get($name);
            }
        }

        return $result;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function extract()
    {
        $result = [];

        foreach ($this->getItems() as $name => $table) {
            $result[$name] = $table->extract();
        }

        return $result;
    }
}