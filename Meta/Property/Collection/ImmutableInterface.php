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
namespace GI\Meta\Property\Collection;

use GI\Meta\Property\PropertyInterface;

interface ImmutableInterface
{
    /**
     * @param string $property
     * @return bool
     */
    public function has(string $property);

    /**
     * @param string $property
     * @return PropertyInterface
     * @throws \Exception
     */
    public function get(string $property);

    /**
     * @return PropertyInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return PropertyInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @return PropertyInterface[]
     */
    public function getItems();

    /**
     * @return bool
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param \Closure $closure
     * @return PropertyInterface[]
     */
    public function filter(\Closure $closure);

    /**
     * @param string $descriptor
     * @return PropertyInterface[]
     */
    public function findByDescriptorName(string $descriptor);

    /**
     * @param string $descriptor
     * @return PropertyInterface
     * @throws \Exception
     */
    public function findOneByDescriptorName(string $descriptor);

    /**
     * @param string $descriptor
     * @param mixed $value
     * @return PropertyInterface[]
     */
    public function findByDescriptorValue(string $descriptor, $value);

    /**
     * @param string $descriptor
     * @param mixed $value
     * @return PropertyInterface
     * @throws \Exception
     */
    public function findOneByDescriptorValue(string $descriptor, $value);
}