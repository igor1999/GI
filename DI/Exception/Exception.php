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
namespace GI\DI\Exception;

use GI\Exception\AbstractException;

class Exception extends AbstractException
{
    const MESSAGE_TEMPLATE = 'Dependency for interface \'%s\' and caller \'%s\' not found';

    const NO_CALLER        = '[not defined]';


    /**
     * Exception constructor.
     * @param mixed $caller
     * @param string $interface
     * @param string $diCaller
     * @param \Throwable|null $previous
     */
    public function __construct($caller, string $interface, string $diCaller = '', \Throwable $previous = null)
    {
        parent::__construct($caller, $previous);

        if (empty($diCaller)) {
            $diCaller = static::NO_CALLER;
        }

        $this->setMessage(static::MESSAGE_TEMPLATE, [$interface, $diCaller]);
    }
}