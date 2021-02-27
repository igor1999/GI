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
namespace GI\Meta\ClassMeta;

use GI\Meta\ClassMeta\Behaviour\Properties\PropertiesInterface as PropertyCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Methods\MethodsInterface as MethodCollectionInterface;
use GI\Meta\Constant\ConstantListInterface;
use GI\Meta\ClassMeta\Behaviour\Traits\TraitsInterface as TraitsCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Interfaces\InterfacesInterface as InterfacesCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Parents\ParentsInterface as ParentsCollectionInterface;

interface ClassMetaInterface 
{
    /**
     * @return \ReflectionClass
     */
    public function getReflection();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getShortName();

    /**
     * @return PropertyCollectionInterface
     */
    public function getProperties();

    /**
     * @return MethodCollectionInterface
     */
    public function getMethods();

    /**
     * @return ConstantListInterface
     */
    public function getConstants();

    /**
     * @return TraitsCollectionInterface
     * @throws \Exception
     */
    public function getTraits();

    /**
     * @return InterfacesCollectionInterface
     * @throws \Exception
     */
    public function getInterfaces();

    /**
     * @return ParentsCollectionInterface
     * @throws \Exception
     */
    public function getParents();

    /**
     * @param mixed $instance
     * @param string|null $descriptor
     * @return array
     * @throws \Exception
     */
    public function extract($instance, string $descriptor = null);

    /**
     * @param mixed $instance
     * @param array $data
     * @param string|null $descriptor
     * @return static
     */
    public function hydrate($instance, array $data, string $descriptor = null);

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

    /**
     * @return bool|self
     */
    public function getParent();

    /**
     * @param array $params
     * @return object
     */
    public function create(array $params = []);

    /**
     * @return object
     */
    public function createWithoutConstructor();
}