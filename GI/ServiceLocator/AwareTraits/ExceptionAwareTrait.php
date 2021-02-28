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
namespace GI\ServiceLocator\AwareTraits;

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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

trait ExceptionAwareTrait
{
    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws AlreadyExistException
     */
    protected function giThrowAlreadyExistException(string $title, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwAlreadyExistException($title, $this, $previous);
    }

    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws AlreadySetException
     */
    protected function giThrowAlreadySetException(string $title, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwAlreadySetException($title, $this, $previous);
    }

    /**
     * @param \Throwable|null $previous
     * @param string $message
     * @param array $messageParams
     * @throws CommonException
     */
    protected function giThrowCommonException(string $message, array $messageParams = [], \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwCommonException($this, $message, $messageParams, $previous);
    }

    /**
     * @param string $dependency
     * @param \Throwable|null $previous
     * @throws DependencyException
     */
    protected function giThrowDependencyException(string $dependency, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwDependencyException($dependency, $this, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param string $format
     * @param \Throwable|null $previous
     * @throws InvalidFormatException
     */
    protected function giThrowInvalidFormatException(
        string $title, $value, string $format, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwInvalidFormatException($title, $value, $format, $this, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param mixed $maximum
     * @param \Throwable|null $previous
     * @throws InvalidMaximumException
     */
    protected function giThrowInvalidMaximumException(string $title, $value, $maximum, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwInvalidMaximumException($title, $value, $maximum, $this, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param mixed $minimum
     * @param \Throwable|null $previous
     * @throws InvalidMinimumException
     */
    protected function giThrowInvalidMinimumException(string $title, $value, $minimum, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwInvalidMinimumException($title, $value, $minimum, $this, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param string $type
     * @param \Throwable|null $previous
     * @throws InvalidTypeException
     */
    protected function giThrowInvalidTypeException(
        string $title, $value, string $type, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwInvalidTypeException($title, $value, $type, $this, $previous);
    }

    /**
     * @param string $title
     * @param mixed $value
     * @param string $template
     * @param \Throwable|null $previous
     * @throws InvalidValueException
     */
    protected function giThrowInvalidValueException(
        string $title, $value, string $template, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwInvalidValueException($title, $value, $template, $this, $previous);
    }

    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws IsEmptyException
     */
    protected function giThrowIsEmptyException(string $title, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwIsEmptyException($title, $this, $previous);
    }

    /**
     * @param string $method
     * @param \Throwable|null $previous
     * @throws MagicMethodException
     */
    protected function giThrowMagicMethodException(string $method, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwMagicMethodException($method, $this, $previous);
    }

    /**
     * @param string $title
     * @param mixed $param
     * @param \Throwable|null $previous
     * @throws NotFoundException
     */
    protected function giThrowNotFoundException(string $title, $param = '', \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwNotFoundException($title, $param, $this, $previous);
    }

    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws NotGivenException
     */
    protected function giThrowNotGivenException(string $title, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwNotGivenException($title, $this, $previous);
    }

    /**
     * @param string|int $key
     * @param \Throwable|null $previous
     * @throws NotInScopeException
     */
    protected function giThrowNotInScopeException($key, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwNotInScopeException($key, $this, $previous);
    }

    /**
     * @param string $title
     * @param \Throwable|null $previous
     * @throws NotSetException
     */
    protected function giThrowNotSetException(string $title, \Throwable $previous = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        $me->giGetServiceLocator()->throwNotSetException($title, $this, $previous);
    }
}