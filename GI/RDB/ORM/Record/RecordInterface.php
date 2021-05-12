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
namespace GI\RDB\ORM\Record;

use GI\Pattern\ArrayExchange\ArrayExchangeInterface;
use GI\SessionExchange\BaseInterface\CacheClassInterface;
use GI\RDB\Driver\DriverInterface;
use GI\RDB\Meta\Table\TableInterface;
use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;

interface RecordInterface extends ArrayExchangeInterface, CacheClassInterface
{
    /**
     * @return TableInterface
     */
    public function getTable();

    /**
     * @return DriverInterface
     */
    public function getDriver();

    /**
     * @return static
     * @throws \Exception
     */
    public function refresh();

    /**
     * @param SQLBuilderInterface|null $builder
     * @return static
     * @throws \Exception
     */
    public function insert(SQLBuilderInterface $builder = null);

    /**
     * @param SQLBuilderInterface|null $builder
     * @return static
     * @throws \Exception
     */
    public function delete(SQLBuilderInterface $builder = null);

    /**
     * @param SQLBuilderInterface|null $builder
     * @return static
     */
    public function update(SQLBuilderInterface $builder = null);

    /**
     * @return bool
     */
    public function isDuplicatedError();

    /**
     * @param string $key
     * @return bool
     */
    public function hasDuplicatedKey(string $key);
}