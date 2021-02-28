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
namespace GI\RDB\Driver\Exception\Statement;

trait ExceptionAwareTrait
{
    /**
     * @param \PDOStatement $statement
     * @param \Throwable|null $previous
     * @throws Exception
     */
    protected function throwPDOStatementException(\PDOStatement $statement, \Throwable $previous = null)
    {
        throw new Exception($statement, $this, $previous);
    }

    /**
     * @param \PDOStatement $statement
     * @param \Throwable|null $previous
     * @return static
     * @throws Exception
     */
    protected function throwPDOStatementExceptionIfExists(\PDOStatement $statement, \Throwable $previous = null)
    {
        if ($statement->errorCode() != 0) {
            $this->throwPDOStatementException($statement, $previous);
        }

        return $this;
    }
}