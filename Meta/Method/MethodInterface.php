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
namespace GI\Meta\Method;

interface MethodInterface 
{
    /**
     * @return \ReflectionMethod
     */
    public function getReflection();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param mixed|null $instance
     * @param array $arguments
     * @return mixed
     */
    public function execute($instance = null, array $arguments = []);

    /**
     * @param string $descriptor
     * @return bool
     */
    public function hasDescriptor(string $descriptor);

    /**
     * @param string $descriptor
     * @return string
     */
    public function getDescriptor(string $descriptor);
}