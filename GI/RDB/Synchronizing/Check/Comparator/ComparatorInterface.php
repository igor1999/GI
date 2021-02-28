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
namespace GI\RDB\Synchronizing\Check\Comparator;

interface ComparatorInterface 
{
    /**
     * @return array
     */
    public function getDumpOnly();

    /**
     * @return array
     */
    public function getDatabaseOnly();

    /**
     * @return array
     */
    public function getUnequals();

    /**
     * @param array $dumpContents
     * @param array $databaseContents
     * @return static
     * @throws \Exception
     */
    public function compare(array $dumpContents, array $databaseContents);

    /**
     * @return int
     */
    public function getCountOfDumpOnly();

    /**
     * @return int
     */
    public function getCountOfDatabaseOnly();

    /**
     * @return int
     */
    public function getCountOfUnequals();

    /**
     * @return bool
     */
    public function isOk();
}