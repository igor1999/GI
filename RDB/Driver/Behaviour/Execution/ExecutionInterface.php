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
namespace GI\RDB\Driver\Behaviour\Execution;

use GI\RDB\Driver\Behaviour\BehaviourInterface;

interface ExecutionInterface extends BehaviourInterface
{
    /**
     * @param string $sql
     * @param array $params
     * @return int
     * @throws \Exception
     */
    public function execute(string $sql, array $params = []);

    /**
     * @param string $sql
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function fetch(string $sql, array $params = []);

    /**
     * @param string $sql
     * @param array $params
     * @return array[]
     * @throws \Exception
     */
    public function fetchAll(string $sql, array $params = []);

    /**
     * @param string $sql
     * @param array $params
     * @param int $index
     * @return array
     * @throws \Exception
     */
    public function fetchColumn(string $sql, array $params = [], int $index = 0);

    /**
     * @param string $sql
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function fetchPair(string $sql, array $params = []);

    /**
     * @param string $sql
     * @param array $params
     * @param int $index
     * @return string
     * @throws \Exception
     */
    public function fetchValue(string $sql, array $params = [], int $index = 0);

    /**
     * @param string $sql
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function fetchMeta(string $sql, array $params = []);

    /**
     * @param \Closure $callback
     * @param string $sql
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function fetchExtra(\Closure $callback, string $sql, array $params = []);

    /**
     * @param \Closure $callback
     * @param string $sql
     * @param array $params
     * @return mixed[]
     * @throws \Exception
     */
    public function fetchAllExtra(\Closure $callback, string $sql, array $params = []);

    /**
     * @param string|null $name
     * @return int
     */
    public function getLastInsertId(string $name = null);
}