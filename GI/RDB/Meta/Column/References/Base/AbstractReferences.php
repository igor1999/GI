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
namespace GI\RDB\Meta\Column\References\Base;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Meta\Column\ColumnInterface;

abstract class AbstractReferences implements ReferencesInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ColumnInterface
     */
    private $column;

    /**
     * @var ColumnInterface[]
     */
    private $items = [];


    /**
     * AbstractReferences constructor.
     * @param ColumnInterface $column
     * @throws \Exception
     */
    public function __construct(ColumnInterface $column)
    {
        $this->column = $column;

        foreach ($this->getContents() as $contents) {
            if ($contents['column'] != $this->column->getName()) {
                continue;
            }

            $referencedTableName  = $contents['referenced_table'];
            $referencedColumnName = $contents['referenced_column'];
            $referencedTable  = $this->column->getTable()->getDriver()->getTableList()->get($referencedTableName);
            $referencedColumn = $referencedTable->getColumnList()->get($referencedColumnName);

            $this->items[] = $referencedColumn;
        }
    }

    /**
     * @return array
     */
    abstract protected function getContents();

    /**
     * @return ColumnInterface
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param string $table
     * @param string $column
     * @return ColumnInterface
     * @throws \Exception
     */
    public function get(string $table, string $column)
    {
        $f = function(ColumnInterface $item) use ($table, $column)
        {
            return ($item->getTable()->getName() == $table) && ($item->getName() == $column);
        };
        $columns = array_filter($this->items, $f);

        if (empty($columns)) {
            $this->getGiServiceLocator()->throwNotInScopeException("$table.$column");
        }

        return array_shift($columns);
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