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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

abstract class AbstractException extends \Exception
{
    use ServiceLocatorAwareTrait;


    /**
     * @var mixed
     */
    private $caller;


    /**
     * Exception constructor.
     * @param mixed $caller
     * @param \Throwable|null $previous
     */
    public function __construct($caller, \Throwable $previous = null)
    {
        $this->caller = $caller;

        parent::__construct('', 0, $previous);
    }

    /**
     * @return mixed
     */
    public function getCaller()
    {
        return $this->caller;
    }

    /**
     * @return string
     */
    public function getCallerClass()
    {
        return is_object($this->getCaller()) ? get_class($this->getCaller()) : gettype($this->getCaller());
    }

    /**
     * @param string $message
     * @param array $params
     * @return static
     */
    protected function setMessage(string $message, array $params = [])
    {
        $this->message = empty($params)
            ? $message
            : call_user_func_array('sprintf', array_merge([$message], $params));

        return $this;
    }

    /**
     * @param mixed $code
     * @return static
     */
    protected function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}