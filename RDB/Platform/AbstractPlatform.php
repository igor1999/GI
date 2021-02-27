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
}