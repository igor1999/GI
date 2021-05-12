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
namespace GI\RDB\Driver;

use GI\RDB\Platform\PlatformInterface;
use GI\RDB\Meta\Table\TableListInterface;

/**
 * Interface DriverInterface
 * @package GI\RDB\Driver
 *
 * @method DriverInterface startTransaction()
 * @method DriverInterface commit()
 * @method DriverInterface rollBack()
 *
 * @method bool isDuplicatedError()
 * @method bool hasDuplicatedKey(string $key)
 * @method int execute(string $sql, array $params = [])
 * @method array fetch(string $sql, array $params = [])
 * @method array fetchAll(string $sql, array $params = [])
 * @method array fetchColumn(string $sql, array $params = [], $index = 0)
 * @method array fetchPair(string $sql, array $params = [])
 * @method string fetchValue(string$sql, array $params = [], $index = 0)
 * @method array fetchMeta(string $sql, array $params = [])
 * @method fetchExtra(\Closure $callback, string $sql, array $params = [])
 * @method array fetchAllExtra(\Closure $callback, string $sql, array $params = [])
 * @method int getLastInsertId(string $name = null)
 */
interface DriverInterface
{
    /**
     * @return string
     */
    public function getDatabase();

    /**
     * @return PlatformInterface
     */
    public function getPlatform();

    /**
     * @return TableListInterface
     */
    public function getTableList();

    /**
     * @param string $table
     * @return array
     */
    public function fetchColumnList(string $table);

    /**
     * @return array
     */
    public function fetchTableList();

    /**
     * @param string $table
     * @return array
     */
    public function fetchTableDetail(string $table);

    /**
     * @param string $table
     * @return array
     */
    public function fetchTableParentReferences(string $table);

    /**
     * @param string $table
     * @return array
     */
    public function fetchTableChildReferences(string $table);

    /**
     * @param string $table
     * @return int
     * @throws \Exception
     */
    public function getTableLastInsertId(string $table);
}