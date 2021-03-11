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
namespace GI\GI\RDB\Meta\Column\References;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Meta\Column\ColumnInterface;

class References implements ReferencesInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ColumnInterface
     */
    private $column;

    /**
     * @var bool
     */
    private $parent = true;

    /**
     * @var ColumnInterface[]
     */
    private $items = [];


    /**
     * References constructor.
     * @param ColumnInterface $column
     * @param bool $parent
     * @throws \Exception
     */
    public function __construct(ColumnInterface $column, bool $parent = true)
    {
        $this->column = $column;
        $this->parent = $parent;

        $references = $this->parent
            ? $this->column->getTable()->getColumnParentReferences($this->column->getName())
            : $this->column->getTable()->getColumnChildReferences($this->column->getName());

        foreach ($references as $contents) {
            $referencedTableName  = $contents['referencedTableName'];
            $referencedColumnName = $contents['referencedColumnName'];

            $referencedTable  = $this->column->getTable()->getDriver()->getTableList()->get($referencedTableName);
            $referencedColumn = $referencedTable->getColumnList()->get($referencedColumnName);

            $this->items[$referencedColumn->getName()] = $referencedColumn;
        }
    }

    /**
     * @return ColumnInterface
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @return bool
     */
    public function isParent()
    {
        return $this->parent;
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
     * @return ColumnInterface
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
     * @return ColumnInterface[]
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