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
namespace GI\RDB\ORM\Exception;

trait ExceptionAwareTrait
{
    /**
     * @param \Throwable|null $previous
     * @throws NotFound
     */
    protected function throwORMNotFoundException(\Throwable $previous = null)
    {
        throw new NotFound($this, $previous);
    }

    /**
     * @param \Throwable|null $previous
     * @throws NotAffected
     */
    protected function throwORMNotAffectedException(\Throwable $previous = null)
    {
        throw new NotAffected($this, $previous);
    }

    /**
     * @param \Throwable|null $previous
     * @throws Duplicated
     */
    protected function throwORMDuplicatedException(\Throwable $previous = null)
    {
        throw new Duplicated($this, $previous);
    }
}