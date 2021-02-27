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
namespace GI\Validator\Container;

use GI\Validator\AbstractValidator;

use GI\Validator\ValidatorInterface;

abstract class AbstractContainer extends AbstractValidator implements ContainerInterface
{
    const KEY_SEPARATOR = '_';


    /**
     * AbstractContainer constructor.
     * @param array $contents
     * @throws \Exception
     */
    public function __construct(array $contents = [])
    {
        if (empty($contents)) {
            $contents = $this->getContents();
        }

        $this->createContents($contents);
    }

    /**
     * @return array
     */
    protected function getContents()
    {
        return [];
    }

    /**
     * @param string|int $key
     * @return ValidatorInterface
     * @throws \Exception
     */
    abstract protected function _get($key);

    /**
     * @param string|int $key
     * @param ValidatorInterface $validator
     * @return static
     */
    abstract protected function _set($key, ValidatorInterface $validator);

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    protected function createContents(array $contents)
    {
        foreach ($contents as $key => $value) {
            if (is_object($value) && ($value instanceof ValidatorInterface)) {
                $validator = $value;
            } elseif (is_array($value) && $this->giGetAssocProcessor()->isAssoc($value)) {
                $validator = $this->giGetValidatorFactory()->createRecursive($value);
            } elseif (is_array($value)) {
                $validator = $this->giGetValidatorFactory()->createChain($value);
            } else {
                $validator = null;
                $this->giThrowInvalidFormatException('Validator', $key, 'validator contents');
            }

            $this->_set($key, $validator);
        }

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function __call($method, array $arguments = [])
    {
        try {
            $keys = $this->giGetPSRFormatParser()->parseWithPrefixGet($method);
        } catch (\Exception $exception) {
            $keys = null;
            $this->giThrowMagicMethodException($method);
        }

        $keys = array_filter(explode(static::KEY_SEPARATOR, $keys));

        $f = function($key)
        {
            return $this->giGetCamelCaseConverter()->convertToHyphenLowerCase($key);
        };
        $keys = array_map($f, $keys);

        return $this->findNodeRecursive($keys);
    }

    /**
     * @param array $keys
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function findNodeRecursive(array $keys)
    {
        if (empty($keys)) {
            $this->giThrowIsEmptyException('Keys for recursive search');
        }

        $localKey = array_shift($keys);

        $result = $this->_get($localKey);

        if (!empty($keys)) {
            if ($result instanceof ContainerInterface) {
                $result = $result->findNodeRecursive($keys);
            } else {
                $this->giThrowNotFoundException('Node in recursive search');
            }
        }

        return $result;
    }
}