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
namespace GI\ServiceLocator\Traits;

use GI\Exception\AlreadyExist as AlreadyExistException;
use GI\Exception\AlreadySet as AlreadySetException;
use GI\Exception\Common as CommonException;
use GI\Exception\Dependency as DependencyException;
use GI\Exception\InvalidFormat as InvalidFormatException;
use GI\Exception\InvalidMaximum as InvalidMaximumException;
use GI\Exception\InvalidMinimum as InvalidMinimumException;
use GI\Exception\InvalidType as InvalidTypeException;
use GI\Exception\InvalidValue as InvalidValueException;
use GI\Exception\IsEmpty as IsEmptyException;
use GI\Exception\MagicMethod as MagicMethodException;
use GI\Exception\NotFound as NotFoundException;
use GI\Exception\NotGiven as NotGivenException;
use GI\Exception\NotInScope as NotInScopeException;
use GI\Exception\NotSet as NotSetException;

trait ExceptionTrait
{
    /**
     * @param string $title
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws AlreadyExistException
     */
    public function throwAlreadyExistException(string $title, $caller, \Throwable $previous = null)
    {
        throw new AlreadyExistException($title, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws AlreadySetException
     */
    public function throwAlreadySetException(string $title, $caller, \Throwable $previous = null)
    {
        throw new AlreadySetException($title, $caller, $previous);
    }

    /**
     * @param mixed $caller
     * @param string $message
     * @param array $messageParams
     * @param \Throwable|null $previous
     * @throws CommonException
     */
    public function throwCommonException(
        $caller, string $message, array $messageParams = [], \Throwable $previous = null)
    {
        throw (new CommonException($caller, $previous))->setMessage($message, $messageParams);
    }

    /**
     * @param string $dependency
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws DependencyException
     */
    public function throwDependencyException(string $dependency, $caller, \Throwable $previous = null)
    {
        throw new DependencyException($dependency, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param string $format
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws InvalidFormatException
     */
    public function throwInvalidFormatException(
        string $title, $value, string $format, $caller, \Throwable $previous = null)
    {
        throw new InvalidFormatException($title, $value, $format, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param mixed $maximum
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws InvalidMaximumException
     */
    public function throwInvalidMaximumException(string $title, $value, $maximum, $caller, \Throwable $previous = null)
    {
        throw new InvalidMaximumException($title, $value, $maximum, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param mixed $minimum
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws InvalidMinimumException
     */
    public function throwInvalidMinimumException(string $title, $value, $minimum, $caller, \Throwable $previous = null)
    {
        throw new InvalidMinimumException($title, $value, $minimum, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param string $type
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws InvalidTypeException
     */
    public function throwInvalidTypeException(
        string $title, $value, string $type, $caller, \Throwable $previous = null)
    {
        throw new InvalidTypeException($title, $value, $type, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param string $template
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws InvalidValueException
     */
    public function throwInvalidValueException(
        string $title, $value, string $template, $caller, \Throwable $previous = null)
    {
        throw new InvalidValueException($title, $value, $template, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws IsEmptyException
     */
    public function throwIsEmptyException(string $title, $caller, \Throwable $previous = null)
    {
        throw new IsEmptyException($title, $caller, $previous);
    }

    /**
     * @param string $method
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws MagicMethodException
     */
    public function throwMagicMethodException(string $method, $caller, \Throwable $previous = null)
    {
        throw new MagicMethodException($method, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $param
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws NotFoundException
     */
    public function throwNotFoundException(string $title, $param, $caller, \Throwable $previous = null)
    {
        throw new NotFoundException($title, $param, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws NotGivenException
     */
    public function throwNotGivenException(string $title, $caller, \Throwable $previous = null)
    {
        throw new NotGivenException($title, $caller, $previous);
    }

    /**
     * @param string|int $key
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws NotInScopeException
     */
    public function throwNotInScopeException($key, $caller, \Throwable $previous = null)
    {
        throw new NotInScopeException($key, $caller, $previous);
    }

    /**
     * @param string $title
     * @param mixed $caller
     * @param \Throwable|null $previous
     * @throws NotSetException
     */
    public function throwNotSetException(string $title, $caller, \Throwable $previous = null)
    {
        throw new NotSetException($title, $caller, $previous);
    }
}