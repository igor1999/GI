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
namespace GI\RDB\Platform\SQLServer;

use GI\RDB\Platform\AbstractPlatform;

class SQLServer extends AbstractPlatform implements SQLServerInterface
{
    /**
     * @param string $string
     * @return string
     */
    protected function quoteString(string $string)
    {
        return '[' . $string . ']';
    }

    /**
     * @throws \Exception
     */
    public function getColumnListQuery()
    {
        $this->giThrowCommonException('Option is not available');
    }

    /**
     * @return string
     */
    public function getTableListQuery()
    {
        return '
            SELECT CONCAT([TABLE_SCHEMA], \'.\', [TABLE_NAME]) AS [name] 
            FROM [information_schema].[TABLES] 
            WHERE [TABLE_TYPE] = \'BASE TABLE\'
                AND [TABLE_CATALOG] = :database 
        ';
    }

    /**
     * @return string
     */
    public function getTableDetailQuery()
    {
        return '
            SELECT *
            FROM [information_schema].[TABLES] 
            WHERE [TABLE_TYPE] = \'BASE TABLE\'
                AND CONCAT([TABLE_SCHEMA], '.', [TABLE_NAME]) = :table
                AND [TABLE_CATALOG] = :database 
        ';
    }

    /**
     * @return string
     */
    public function getTableIdentityQuery()
    {
        return '
            SELECT *
            FROM [information_schema].[COLUMNS] 
            WHERE CONCAT([TABLE_SCHEMA], '.', [TABLE_NAME]) = :table
                AND [TABLE_CATALOG] = :database 
                AND [IS_IDENTITY] = 1 
        ';
    }
}