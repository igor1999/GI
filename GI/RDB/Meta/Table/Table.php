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

use GI\RDB\Meta\Column\ColumnList;
use GI\RDB\Meta\Table\QueryBuilder\QueryBuilder;
use GI\RDB\Meta\Table\PHPNames\PHPNames;
use GI\RDB\Meta\Table\References\ParentReferences\References as ParentReferences;
use GI\RDB\Meta\Table\References\ChildReferences\References as ChildReferences;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\RDB\Meta\Exception\ExceptionAwareTrait;

use GI\RDB\Driver\DriverInterface;
use GI\RDB\Meta\Column\ColumnListInterface;
use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;
use GI\RDB\Meta\Table\QueryBuilder\QueryBuilderInterface;
use GI\RDB\Meta\Table\PHPNames\PHPNamesInterface;
use GI\RDB\Meta\Table\References\ParentReferences\ReferencesInterface as ParentReferencesInterface;
use GI\RDB\Meta\Table\References\ChildReferences\ReferencesInterface as ChildReferencesInterface;

class Table implements TableInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    const ALIAS_SEPARATOR = '_';


    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var ColumnListInterface
     */
    private $columnList;

    /**
     * @var QueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var PHPNamesInterface
     */
    private $phpNames;

    /**
     * @var array
     */
    private $parentReferences;

    /**
     * @var array
     */
    private $childReferences;

    /**
     * @var ParentReferencesInterface
     */
    private $parentReferencedTables;

    /**
     * @var ChildReferencesInterface
     */
    private $childReferencedTables;


    /**
     * Table constructor.
     * @param DriverInterface $driver
     * @param string $name
     * @throws \Exception
     */
    public function __construct(DriverInterface $driver, string $name)
    {
        $this->driver = $driver;
        $this->name   = $name;

        $this->columnList = $this->giGetDi(ColumnListInterface::class, new ColumnList($this),  [$this]);

        $this->queryBuilder = $this->giGetDi(QueryBuilderInterface::class, new QueryBuilder($this),  [$this]);

        $this->phpNames = $this->giGetDi(PHPNamesInterface::class, new PHPNames($this),  [$this]);
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getDriver()->getPlatform()->joinEntities([$this->getDriver()->getDatabase(), $this->name]);
    }

    /**
     * @return string
     */
    public function getSchema()
    {
        $entities = $this->getDriver()->getPlatform()->splitEntities($this->name);

        return (count($entities) > 1) ? $entities[0] : '';
    }

    /**
     * @return string
     */
    public function getLocalName()
    {
        $entities = $this->getDriver()->getPlatform()->splitEntities($this->name);

        return (count($entities) > 1) ? $entities[1] : $this->name;
    }

    /**
     * @return ColumnListInterface
     */
    public function getColumnList()
    {
        return $this->columnList;
    }

    /**
     * @return QueryBuilderInterface
     */
    protected function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @return PHPNamesInterface
     */
    public function getPhpNames()
    {
        return $this->phpNames;
    }

    /**
     * @return array
     */
    public function fetchColumnList()
    {
        return $this->getDriver()->fetchColumnList($this->name);
    }

    /**
     * @return array
     */
    public function fetchTableDetail()
    {
        return $this->getDriver()->fetchTableDetail($this->name);
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getLastInsertId()
    {
        return $this->getDriver()->getTableLastInsertId($this->name);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function extract()
    {
        return $this->getColumnList()->extract();
    }

    /**
     * @param array $contents
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function insert(array $contents, SQLBuilderInterface $builder = null)
    {
        $sql = $this->getQueryBuilder()->insert($contents, $builder);

        return $this->getDriver()->execute($sql, $contents);
    }

    /**
     * @param array $contents
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function delete(array $contents, SQLBuilderInterface $builder = null)
    {
        $sql = $this->getQueryBuilder()->delete($contents, $builder);

        return $this->getDriver()->execute($sql, $contents);
    }

    /**
     * @param array $values
     * @param array $conditions
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function update(array $values, array $conditions, SQLBuilderInterface $builder = null)
    {
        $sql = $this->getQueryBuilder()->update($values, $conditions, $builder);

        return $this->getDriver()->execute($sql, array_merge($values, $conditions));
    }

    /**
     * @param array $contents
     * @param array $order
     * @param SQLBuilderInterface|null $builder
     * @return array[]
     * @throws \Exception
    */
    public function select(array $contents = [], array $order = [], SQLBuilderInterface $builder = null)
    {
        $sql = $this->getQueryBuilder()->select($contents, $order, $builder);

        return $this->getDriver()->fetchAll($sql, $contents);
    }

    /**
     * @param array $contents
     * @param array $order
     * @param SQLBuilderInterface|null $builder
     * @return array
     * @throws \Exception
     */
    public function selectOne(array $contents = [], array $order = [], SQLBuilderInterface $builder = null)
    {
        $sql = $this->getQueryBuilder()->select($contents, $order, $builder);

        return $this->getDriver()->fetch($sql, $contents);
    }

    /**
     * @param mixed $values
     * @param SQLBuilderInterface|null $builder
     * @return array
     * @throws \Exception
     */
    public function find($values, SQLBuilderInterface $builder = null)
    {
        if (!$this->getColumnList()->hasPrimary()) {
            $this->throwMetaException('This table has no primary key', $this);
        }

        if (!is_array($values)) {
            $values = [$values];
        }
        if (count($values) != count($this->getColumnList()->getPrimary())) {
            $this->throwMetaException('Given values and primary key attributes do not match', $this);
        }

        $contents = array_combine(array_keys($this->getColumnList()->getPrimary()), $values);

        return $this->selectOne($contents, [], $builder);
    }

    /**
     * @return array
     */
    public function getParentReferences()
    {
        if (!is_array($this->parentReferences)) {
            $this->parentReferences = $this->getDriver()->fetchTableParentReferences($this->name);
        }

        return $this->parentReferences;
    }

    /**
     * @return array
     */
    public function getChildReferences()
    {
        if (!is_array($this->childReferences)) {
            $this->childReferences = $this->getDriver()->fetchTableChildReferences($this->name);
        }

        return $this->childReferences;
    }

    /**
     * @return ParentReferencesInterface
     * @throws \Exception
     */
    public function getParentReferencedTables()
    {
        if (!($this->parentReferencedTables instanceof ParentReferencesInterface)) {
            $this->parentReferencedTables = $this->giGetDi(
                ParentReferencesInterface::class, ParentReferences::class, [$this]
            );
        }

        return $this->parentReferencedTables;
    }

    /**
     * @return ChildReferencesInterface
     * @throws \Exception
     */
    public function getChildReferencedTables()
    {
        if (!($this->childReferencedTables instanceof ChildReferencesInterface)) {
            $this->childReferencedTables = $this->giGetDi(
                ChildReferencesInterface::class, ChildReferences::class, [$this]
            );
        }

        return $this->childReferencedTables;
    }
}