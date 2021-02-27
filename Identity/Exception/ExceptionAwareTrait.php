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
namespace GI\Identity\Exception;

trait ExceptionAwareTrait
{
    /**
     * @param string|int $key
     * @param \Throwable|null $previous
     * @throws IdentityKey
     */
    protected function throwIdentityKeyException($key, \Throwable $previous = null)
    {
        throw new IdentityKey($key, $this, $previous);
    }

    /**
     * @param string $action
     * @param \Throwable|null $previous
     * @throws Access
     */
    protected function throwIdentityAccessException(string $action, \Throwable $previous = null)
    {
        throw new Access($action, $this, $previous);
    }
}