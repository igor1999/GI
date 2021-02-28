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
namespace GI\Meta\Method\Collection;

use GI\Meta\Method\MethodInterface;

interface ImmutableInterface
{
    const HYDRATION_DESCRIPTOR  = 'hydrate';

    const EXTRACTION_DESCRIPTOR = 'extract';

    const VALIDATION_DESCRIPTOR = 'validate';

    const PARSING_DESCRIPTOR    = 'parse';


    /**
     * @param string $method
     * @return bool
     */
    public function has(string $method);

    /**
     * @param string $method
     * @return MethodInterface
     * @throws \Exception
     */
    public function get(string $method);

    /**
     * @return MethodInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return MethodInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @return MethodInterface[]
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
     * @return MethodInterface[]
     */
    public function filter(\Closure $closure);

    /**
     * @param string $descriptor
     * @return MethodInterface[]
     */
    public function findByDescriptorName(string $descriptor);

    /**
     * @param string $descriptor
     * @return MethodInterface
     * @throws \Exception
     */
    public function findOneByDescriptorName(string $descriptor);

    /**
     * @param string $descriptor
     * @param mixed $value
     * @return MethodInterface[]
     */
    public function findByDescriptorValue(string $descriptor, $value);

    /**
     * @param string $descriptor
     * @param mixed $value
     * @return MethodInterface
     * @throws \Exception
     */
    public function findOneByDescriptorValue(string $descriptor, $value);

    /**
     * @param string $property
     * @return bool
     */
    public function hasGetter(string $property);

    /**
     * @param mixed|null $instance
     * @param string $property
     * @throws \Exception
     */
    public function executeGetter($instance, string $property);

    /**
     * @param string $property
     * @return bool
     */
    public function hasSetter(string $property);

    /**
     * @param mixed|null $instance
     * @param string $property
     * @param mixed $value
     * @return static
     * @throws \Exception
     */
    public function executeSetter($instance, string $property, $value);

    /**
     * @param mixed $instance
     * @param string|null $descriptor
     * @return array
     * @throws \Exception
     */
    public function extract($instance, string $descriptor = null);

    /**
     * @param mixed $instance
     * @param array $contents
     * @param string|null $descriptor
     * @return static
     */
    public function hydrate($instance, array $contents, string $descriptor = null);

    /**
     * @param mixed $instance
     * @param string|null $descriptor
     * @return static
     */
    public function validate($instance, string $descriptor = null);

    /**
     * @param mixed $instance
     * @param string $source
     * @param string|null $descriptor
     * @param string|null $placeHolderTemplate
     * @return string
     * @throws \Exception
     */
    public function parse($instance, string $source, string $descriptor = null, string $placeHolderTemplate = null);
}