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
namespace GI\Meta\ClassMeta\Behaviour\Properties;

use GI\Meta\Property\Collection\Immutable;
use GI\Meta\Property\Property;

use GI\Meta\ClassMeta\Behaviour\OwnerAware\OwnerTrait;

use GI\Meta\ClassMeta\ClassMetaInterface;

class Properties extends Immutable implements PropertiesInterface
{
    use OwnerTrait;


    /**
     * Properties constructor.
     * @param ClassMetaInterface $owner
     */
    public function __construct(ClassMetaInterface $owner)
    {
        parent::__construct();

       $this->owner = $owner;

        foreach ($this->owner->getReflection()->getProperties() as $propertyReflection) {
            $this->_set($this->createProperty($propertyReflection));
        }
    }

    /**
     * @param \ReflectionProperty $propertyReflection
     * @return Property
     */
    protected function createProperty(\ReflectionProperty $propertyReflection)
    {
        return new Property($propertyReflection);
    }
}