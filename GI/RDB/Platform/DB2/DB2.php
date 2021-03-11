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
namespace GI\RDB\Platform\DB2;

use GI\RDB\Platform\AbstractPlatform;

class DB2 extends AbstractPlatform implements DB2Interface
{
    /**
     * @param string $string
     * @return string
     */
    protected function quoteString(string $string)
    {
        return '"' . $string . '"';
    }

    /**
     * @throws \Exception
     */
    public function getColumnListQuery()
    {
        $this->giThrowCommonException('Option is not available');
    }

    /**
     * @throws \Exception
     */
    public function getTableListQuery()
    {
        $this->giThrowCommonException('Option is not available');
    }

    /**
     * @throws \Exception
     */
    public function getTableDetailQuery()
    {
        $this->giThrowCommonException('Option is not available');
    }

    /**
     * @throws \Exception
     */
    public function getTableRelationsQuery()
    {
        $this->giThrowCommonException('Option is not available');
    }
}