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
namespace GI\Meta\ClassMeta\Collection;

use GI\Meta\ClassMeta\ClassMetaInterface;

interface ImmutableInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @return ClassMetaInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param \Closure $filter
     * @return ClassMetaInterface[]
     */
    public function filter(\Closure $filter);

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findParents(ClassMetaInterface $class);

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findChildren(ClassMetaInterface $class);

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findDescendants(ClassMetaInterface $class);

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findAscendants(ClassMetaInterface $class);

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findImplementations(ClassMetaInterface $class);

    /**
     * @param ClassMetaInterface $class
     * @return ClassMetaInterface[]
     */
    public function findByImplementation(ClassMetaInterface $class);

    /**
     * @return ClassMetaInterface[]
     */
    public function findClasses();

    /**
     * @return ClassMetaInterface[]
     */
    public function findAbstractClasses();

    /**
     * @return ClassMetaInterface[]
     */
    public function findTraits();

    /**
     * @return ClassMetaInterface[]
     */
    public function findInterfaces();
}