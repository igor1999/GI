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
namespace GI\RDB\ORM\Set;

use GI\Pattern\ArrayExchange\ArrayExchangeInterface;
use GI\RDB\ORM\Record\RecordInterface;
use GI\RDB\Driver\DriverInterface;
use GI\RDB\Meta\Table\TableInterface;
use GI\RDB\ORM\Set\Index\Collection\CollectionInterface as IndexCollectionInterface;
use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;

interface SetInterface extends  ArrayExchangeInterface
{
    /**
     * @return IndexCollectionInterface
     * @throws \Exception
     */
    public function getIndexList();

    /**
     * @return TableInterface
     */
    public function getTable();

    /**
     * @return DriverInterface
     */
    public function getDriver();

    /**
     * @return string
     */
    public function getItemClass();

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return RecordInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return RecordInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return RecordInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @return RecordInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return int
     */
    public function isEmpty();

    /**
     * @return RecordInterface
     * @throws \Exception
     */
    public function add();

    /**
     * @param int $index
     * @return RecordInterface
     * @throws \Exception
     */
    public function addBefore(int $index);

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index);

    /**
     * @return static
     * @throws \Exception
     */
    public function clean();

    /**
     * @param array $contents
     * @param string|null $order
     * @return static
     * @throws \Exception
     */
    public function select(array $contents, string $order = null);

    /**
     * @param string $proxyClass
     * @param array $contents
     * @param string|null $order
     * @return static
     * @throws \Exception
     */
    public function selectByProxy(string $proxyClass, array $contents, string $order = null);

    /**
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function insert(SQLBuilderInterface $builder = null);

    /**
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function delete(SQLBuilderInterface $builder = null);

    /**
     * @param SQLBuilderInterface|null $builder
     * @return int
     */
    public function update(SQLBuilderInterface $builder = null);
}