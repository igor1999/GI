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

use GI\Exception\AbstractException;

class Access extends AbstractException
{
    const MESSAGE_TEMPLATE = 'User has no privileges to action \'%s\'';


    /**
     * Access constructor.
     * @param string $action
     * @param mixed $caller
     * @param \Throwable|null $previous
     */
    public function __construct(string $action, $caller, \Throwable $previous = null)
    {
        parent::__construct($caller, $previous);

        $message = sprintf(static::MESSAGE_TEMPLATE, $action);

        $this->setMessage($message);
    }
}