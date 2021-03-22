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
namespace GI\RDB\Meta\Table\References\Base;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Meta\Table\TableInterface;

abstract class AbstractReferences implements ReferencesInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @var TableInterface[]
     */
    private $items = [];


    /**
     * AbstractReferences constructor.
     * @param TableInterface $table
     * @throws \Exception
     */
    public function __construct(TableInterface $table)
    {
        $this->table = $table;

        $contents = $this->getContents();

        $f = function(array $row)
        {
            return $row['referenced_table'];
        };
        $contents = array_unique(array_map($f, $contents));

        foreach ($contents as $referencedTableName) {
            $this->items[$referencedTableName] = $this->table->getDriver()->getTableList()->get($referencedTableName);
        }
    }

    /**
     * @return array
     */
    abstract protected function getContents();

    /**
     * @return TableInterface
     */
    public function getTable()
    {
        return $this->table;
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

        return $this->items[$name];
    }

    /**
     * @return TableInterface[]
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
}