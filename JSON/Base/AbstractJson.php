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
namespace GI\JSON\Base;

use GI\JSON\Exception\Exception;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\JSON\Exception\ExceptionAwareTrait;

abstract class AbstractJson implements JsonInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    const DEFAULT_DEPTH = 512;


    const FLAG_SETTER_PREFIX = 'setFlag';


    /**
     * @var int
     */
    private $depth = self::DEFAULT_DEPTH;


    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     * @return static
     */
    public function setDepth(int $depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @return static
     */
    public function setDepthToDefault()
    {
        $this->setDepth(static::DEFAULT_DEPTH);

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return static
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $flag = $this->giGetPSRFormatParser()->parseAfterPrefix($method, static::FLAG_SETTER_PREFIX);
        } catch (\Exception $exception) {
            $flag = null;
            $this->giThrowMagicMethodException($method);
        }

        $flagSetter = $this->giGetPSRFormatBuilder()->buildSet($flag);

        try {
            call_user_func_array([$this->getFlags(), $flagSetter], $arguments);
        } catch (\Exception $exception) {
            $this->giThrowMagicMethodException($method);
        }

        return $this;
    }

    /**
     * @return static
     * @throws Exception
     */
    protected function validate()
    {
        if (json_last_error() != JSON_ERROR_NONE) {
            $this->throwJSONException();
        }

        return $this;
    }
}