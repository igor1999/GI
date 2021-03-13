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

use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\RDB\Driver\DriverInterface;
use GI\RDB\Meta\Column\ColumnListInterface;
use GI\GI\RDB\Meta\Table\PHPNames\PHPNamesInterface;
use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;
use GI\GI\RDB\Meta\Table\References\ChildReferences\ReferencesInterface as ChildReferencesInterface;
use GI\GI\RDB\Meta\Table\References\ParentReferences\ReferencesInterface as ParentReferencesInterface;

interface TableInterface extends ExtractionInterface
{

    /**
     * @return DriverInterface
     */
    public function getDriver();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getFullName();

    /**
     * @return string
     */
    public function getSchema();

    /**
     * @return string
     */
    public function getLocalName();

    /**
     * @return string
     */
    public function getSchemaNamespace();

    /**
     * @return string
     */
    public function getLocalNamespace();

    /**
     * @return string
     */
    public function getNamespace();

    /**
     * @return string
     */
    public function getDir();

    /**
     * @return string
     */
    public function getAlias();

    /**
     * @return string
     */
    public function getMethodGetter();

    /**
     * @return string
     */
    public function getMethodCreator();

    /**
     * @return ColumnListInterface
     */
    public function getColumnList();

    /**
     * @return PHPNamesInterface
     */
    public function getPhpNames();

    /**
     * @return array
     */
    public function fetchColumnList();

    /**
     * @return array
     */
    public function fetchTableDetail();

    /**
     * @return int
     * @throws \Exception
     */
    public function getLastInsertId();

    /**
     * @param array $contents
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function insert(array $contents, SQLBuilderInterface $builder = null);

    /**
     * @param array $contents
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function delete(array $contents, SQLBuilderInterface $builder = null);

    /**
     * @param array $values
     * @param array $conditions
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function update(array $values, array $conditions, SQLBuilderInterface $builder = null);

    /**
     * @param array $contents
     * @param string|null $order
     * @param SQLBuilderInterface|null $builder
     * @return array[]
     * @throws \Exception
     */
    public function select(array $contents, string $order = null, SQLBuilderInterface $builder = null);

    /**
     * @param array $contents
     * @param string|null $order
     * @param SQLBuilderInterface|null $builder
     * @return array
     * @throws \Exception
     */
    public function selectOne(array $contents, string $order = null, SQLBuilderInterface $builder = null);

    /**
     * @param mixed $values
     * @param SQLBuilderInterface|null $builder
     * @return array
     * @throws \Exception
     */
    public function find($values, SQLBuilderInterface $builder = null);

    /**
     * @return array
     */
    public function getParentReferences();

    /**
     * @return array
     */
    public function getChildReferences();

    /**
     * @return ParentReferencesInterface
     * @throws \Exception
     */
    public function getParentReferencedTables();

    /**
     * @return ChildReferencesInterface
     * @throws \Exception
     */
    public function getChildReferencedTables();
}