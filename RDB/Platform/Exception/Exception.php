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
namespace GI\RDB\Platform\Exception;

use GI\RDB\Exception\AbstractException;

class Exception extends AbstractException
{
    const MESSAGE_TEMPLATE = 'Platform for driver \'%s\' is not available';


    /**
     * Exception constructor.
     * @param \PDO $pdo
     * @param mixed $caller
     * @param \Throwable|null $previous
     */
    public function __construct(\PDO $pdo, $caller, \Throwable $previous = null)
    {
        parent::__construct($caller, $previous);

        $driver = $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);

        $this->setMessage(static::MESSAGE_TEMPLATE, [$driver]);
    }
}