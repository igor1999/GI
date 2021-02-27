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
namespace GI\Exception;

class InvalidType extends AbstractException
{
    const MESSAGE_TEMPLATE = '%s \'%s\' does not match with type \'%s\'';

    const TYPE_TEMPLATE    = '[%s]';


    /**
     * InvalidType constructor.
     * @param string $title
     * @param mixed $value
     * @param string $type
     * @param mixed $caller
     * @param \Throwable|null $previous
     */
    public function __construct(string $title, $value, string $type, $caller, \Throwable $previous = null)
    {
        parent::__construct($caller, $previous);

        if (is_array($value) || is_resource($value)) {
            $value = sprintf(static::TYPE_TEMPLATE, gettype($value));
        } elseif (is_object($value)) {
            $value = sprintf(static::TYPE_TEMPLATE, get_class($value));
        }

        $this->setMessage(static::MESSAGE_TEMPLATE, [$title, $value, $type]);
    }
}