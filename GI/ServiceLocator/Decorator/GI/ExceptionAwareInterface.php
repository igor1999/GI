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
namespace GI\ServiceLocator\Decorator\GI;

interface ExceptionAwareInterface
{
    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwAlreadyExistException(string $title, \Throwable $previous = null);

    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwAlreadySetException(string $title, \Throwable $previous = null);

    /**
     * @param \Throwable|null $previous
     * @param string $message
     * @param array $messageParams
     * @throws \Exception
     */
    public function throwCommonException(string $message, array $messageParams = [], \Throwable $previous = null);

    /**
     * @param string $dependency
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwDependencyException(string $dependency, \Throwable $previous = null);

    /**
     * @param string $title
     * @param mixed $value
     * @param string $format
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwInvalidFormatException(
        string $title, $value, string $format, \Throwable $previous = null);

    /**
     * @param string $title
     * @param mixed $value
     * @param mixed $maximum
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwInvalidMaximumException(string $title, $value, $maximum, \Throwable $previous = null);

    /**
     * @param string $title
     * @param mixed $value
     * @param mixed $minimum
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwInvalidMinimumException(string $title, $value, $minimum, \Throwable $previous = null);

    /**
     * @param string $title
     * @param mixed $value
     * @param string $type
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwInvalidTypeException(
        string $title, $value, string $type, \Throwable $previous = null);

    /**
     * @param string $title
     * @param mixed $value
     * @param string $template
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwInvalidValueException(
        string $title, $value, string $template, \Throwable $previous = null);

    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwIsEmptyException(string $title, \Throwable $previous = null);

    /**
     * @param string $method
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwMagicMethodException(string $method, \Throwable $previous = null);

    /**
     * @param string $title
     * @param mixed $param
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwNotFoundException(string $title, $param = '', \Throwable $previous = null);

    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwNotGivenException(string $title, \Throwable $previous = null);

    /**
     * @param string|int $key
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwNotInScopeException($key, \Throwable $previous = null);

    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws \Exception
     */
    public function throwNotSetException(string $title, \Throwable $previous = null);
}