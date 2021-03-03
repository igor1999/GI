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
namespace GI\RDB\Platform;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

abstract class AbstractPlatform implements PlatformInterface
{
    use ServiceLocatorAwareTrait;


    const PHP_INT_TYPES = [];

    const PHP_INT_TYPE  = 'int';

    const PHP_FLOAT_TYPES = [];

    const PHP_FLOAT_TYPE  = 'float';

    const PHP_STRING_TYPES = [];

    const PHP_STRING_TYPE  = 'string';

    const PHP_DATE_TYPES = [];

    const PHP_BOOL_TYPES = [];


    const PHP_UNDEFINED_TYPE = 'undefined';


    /**
     * @param string|array $entity
     * @return string
     */
    public function quoteEntity($entity)
    {
        if (is_string($entity) && strpos($entity, self::ENTITY_POINTER) !== false) {
            $entity = $this->splitEntities($entity);
        }

        if (is_array($entity)) {
            $f = function($entity)
            {
                return $this->quoteEntity($entity);
            };
            $result = array_map($f, $entity);
            $result = $this->joinEntities($result);
        } else {
            $result = $this->quoteString($entity);
        }

        return $result;
    }

    /**
     * @param string $string
     * @return string
     */
    abstract protected function quoteString(string $string);

    /**
     * @param array $identifiers
     * @return string
     */
    public function joinEntities(array $identifiers)
    {
        return implode(self::ENTITY_POINTER, $identifiers);
    }

    /**
     * @param string $identifiers
     * @return array
     */
    public function splitEntities(string $identifiers)
    {
        return explode(self::ENTITY_POINTER, $identifiers);
    }

    /**
     * @param string $dbType
     * @return string
     */
    public function getPHPType(string $dbType)
    {
        if (in_array($dbType, static::PHP_INT_TYPES)) {
            $type = static::PHP_INT_TYPE;
        } elseif (in_array($dbType, static::PHP_FLOAT_TYPES)) {
            $type = static::PHP_FLOAT_TYPE;
        } elseif (in_array($dbType, static::PHP_STRING_TYPES)) {
            $type = static::PHP_STRING_TYPE;
        } else {
            $type = static::PHP_UNDEFINED_TYPE;
        }

        return $type;
    }

    /**
     * @param string $dbType
     * @return bool
     */
    public function isDatePHPType(string $dbType)
    {
        return in_array($dbType, static::PHP_DATE_TYPES);
    }

    /**
     * @param string $dbType
     * @return bool
     */
    public function isBoolPHPType(string $dbType)
    {
        return in_array($dbType, static::PHP_BOOL_TYPES);
    }
}