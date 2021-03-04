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
namespace GI\RDB\Meta\Column;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\RDB\Meta\Exception\ExceptionAwareTrait;

use GI\RDB\Meta\Table\TableInterface;

class ColumnList implements ColumnListInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @var ColumnInterface[]
     */
    private $items = [];

    /**
     * @var ColumnInterface[]
     */
    private $primary = [];

    /**
     * @var ColumnInterface|null
     */
    private $identity;


    /**
     * Columns constructor.
     *
     * @param TableInterface $table
     * @throws \Exception
     */
    public function __construct(TableInterface $table)
    {
        $this->table = $table;

        foreach ($this->table->fetchColumnList() as $columnContent) {
            $column = $this->createColumn($columnContent);

            $this->items[$column->getName()] = $column;

            if ($column->isPrimary()) {
                $this->primary[$column->getName()] = $column;
            }

            if ($column->isIdentity()) {
                $this->identity = $column;
            }
        }
    }

    /**
     * @return TableInterface
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param array $content
     * @return ColumnInterface
     * @throws \Exception
     */
    protected function createColumn(array $content)
    {
        try {
            $column = $this->giGetDi(
                ColumnInterface::class, new Column($this->getTable(), $content), [$this->getTable(), $content]
            );
        } catch (\Exception $e) {
            $column = new Column($this->getTable(), $content);
        }

        return $column;
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

    /**
     * @param string $name
     * @return bool
     */
    public function hasPrimaryAttribute(string $name)
    {
        return array_key_exists($name, $this->primary);
    }

    /**
     * @param string $name
     * @return ColumnInterface
     * @throws \Exception
     */
    public function getPrimaryAttribute(string $name)
    {
        if (!$this->hasPrimaryAttribute($name)) {
            $this->giThrowNotInScopeException($name);
        }

        return $this->primary[$name];
    }

    /**
     * @return bool
     */
    public function hasPrimary()
    {
        return !empty($this->primary);
    }

    /**
     * @return ColumnInterface[]
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @return ColumnInterface[]
     */
    public function getNonPrimary()
    {
        return array_diff_key($this->getItems(), $this->getPrimary());
    }

    /**
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->identity instanceof ColumnInterface;
    }

    /**
     * @return ColumnInterface
     * @throws \Exception
     */
    public function getIdentity()
    {
        if (!$this->hasIdentity()) {
            $this->throwMetaException('Identity not set', $this->getTable());
        }

        return $this->identity;
    }

    /**
     * @return ColumnInterface[]
     */
    public function getNonIdentity()
    {
        try {
            $result = array_diff_key($this->getItems(), [$this->getIdentity()->getName() => null]);
        } catch (\Exception $e) {
            $result = $this->getItems();
        }

        return $result;
    }

    /**
     * @return array[]
     * @throws \Exception
     */
    public function extract()
    {
        $f = function(ColumnInterface $column)
        {
            return $column->extract();
        };

        return array_map($f, $this->items);
    }
}