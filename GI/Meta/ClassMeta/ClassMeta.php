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

use GI\Meta\ClassMeta\Behaviour\Properties\Properties as PropertyCollection;
use GI\Meta\ClassMeta\Behaviour\Methods\Methods as MethodCollection;
use GI\Meta\ClassMeta\Behaviour\Constants\StaticConstants\StaticConstants as StaticConstantsCollection;
use GI\Meta\ClassMeta\Behaviour\Constants\SelfConstants\SelfConstants as SelfConstantsCollection;
use GI\Meta\ClassMeta\Behaviour\Traits\Traits as TraitsCollection;
use GI\Meta\ClassMeta\Behaviour\Interfaces\Interfaces as InterfacesCollection;
use GI\Meta\ClassMeta\Behaviour\Parents\Parents as ParentsCollection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\ClassMeta\Behaviour\Properties\PropertiesInterface as PropertyCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Methods\MethodsInterface as MethodCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Constants\StaticConstants\StaticConstantsInterface as StaticConstantsCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Constants\SelfConstants\SelfConstantsInterface as SelfConstantsCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Traits\TraitsInterface as TraitsCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Interfaces\InterfacesInterface as InterfacesCollectionInterface;
use GI\Meta\ClassMeta\Behaviour\Parents\ParentsInterface as ParentsCollectionInterface;

class ClassMeta implements ClassMetaInterface
{
    use ServiceLocatorAwareTrait;


    const DESCRIPTOR_PREFIX            = '@';

    const DESCRIPTOR_REG_EXP           = '/@%s\s+(\S+)(\r|\n|\t)/U';

    const DESCRIPTOR_REG_EXP_DELIMITER = '/';


    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * @var PropertyCollectionInterface
     */
    private $properties;

    /**
     * @var MethodCollectionInterface
     */
    private $methods;

    /**
     * @var StaticConstantsCollectionInterface
     */
    private $staticConstants;

    /**
     * @var SelfConstantsCollectionInterface
     */
    private $selfConstants;

    /**
     * @var TraitsCollectionInterface
     */
    private $traits;

    /**
     * @var InterfacesCollectionInterface
     */
    private $interfaces;

    /**
     * @var ParentsCollectionInterface
     */
    private $parents;


    /**
     * ClassMeta constructor.
     * @param mixed $source
     * @throws \Exception
     */
    public function __construct($source)
    {
        $this->reflection      = new \ReflectionClass($source);
        $this->properties      = $this->createPropertyCollection();
        $this->methods         = $this->createMethodCollection();
        $this->staticConstants = $this->createStaticConstantsCollection();
        $this->selfConstants   = $this->createSelfConstantsCollection();
    }

    /**
     * @return PropertyCollection
     */
    protected function createPropertyCollection()
    {
        return new PropertyCollection($this);
    }

    /**
     * @return MethodCollection
     */
    protected function createMethodCollection()
    {
        return new MethodCollection($this);
    }

    /**
     * @return StaticConstantsCollection
     * @throws \Exception
     */
    protected function createStaticConstantsCollection()
    {
        return new StaticConstantsCollection($this);
    }

    /**
     * @return SelfConstantsCollection
     * @throws \Exception
     */
    protected function createSelfConstantsCollection()
    {
        return new SelfConstantsCollection($this);
    }

    /**
     * @return TraitsCollection
     * @throws \Exception
     */
    protected function createTraitsCollection()
    {
        return new TraitsCollection($this);
    }

    /**
     * @return InterfacesCollection
     * @throws \Exception
     */
    protected function createInterfacesCollection()
    {
        return new InterfacesCollection($this);
    }

    /**
     * @return ParentsCollection
     * @throws \Exception
     */
    protected function createParentsCollection()
    {
        return new ParentsCollection($this);
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflection()
    {
        return $this->reflection;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->reflection->getName();
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->reflection->getShortName();
    }

    /**
     * @return PropertyCollectionInterface
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return MethodCollectionInterface
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return StaticConstantsCollectionInterface
     */
    public function getStaticConstants()
    {
        return $this->staticConstants;
    }

    /**
     * @return SelfConstantsCollectionInterface
     */
    public function getSelfConstants()
    {
        return $this->selfConstants;
    }

    /**
     * @return TraitsCollectionInterface
     * @throws \Exception
     */
    public function getTraits()
    {
        if (!($this->traits instanceof TraitsCollectionInterface)) {
            $this->traits = $this->createTraitsCollection();
        }

        return $this->traits;
    }

    /**
     * @return InterfacesCollectionInterface
     * @throws \Exception
     */
    public function getInterfaces()
    {
        if (!($this->interfaces instanceof InterfacesCollectionInterface)) {
            $this->interfaces = $this->createInterfacesCollection();
        }

        return $this->interfaces;
    }

    /**
     * @return ParentsCollectionInterface
     * @throws \Exception
     */
    public function getParents()
    {
        if (!($this->parents instanceof ParentsCollectionInterface)) {
            $this->parents = $this->createParentsCollection();
        }

        return $this->parents;
    }

    /**
     * @param mixed $instance
     * @param string|null $descriptor
     * @return array
     * @throws \Exception
     */
    public function extract($instance, string $descriptor = null)
    {
        return $this->getMethods()->extract($instance, $descriptor);
    }

    /**
     * @param mixed $instance
     * @param array $data
     * @param string|null $descriptor
     * @return static
     */
    public function hydrate($instance, array $data, string $descriptor = null)
    {
        $this->getMethods()->hydrate($instance, $data, $descriptor);

        return $this;
    }

    /**
     * @param string $descriptor
     * @return bool
     */
    public function hasDescriptor(string $descriptor)
    {
        return strpos($this->reflection->getDocComment(), static::DESCRIPTOR_PREFIX . $descriptor) !== false;
    }

    /**
     * @param string $descriptor
     * @return string
     */
    public function getDescriptor(string $descriptor)
    {
        $regExp = sprintf(
            static::DESCRIPTOR_REG_EXP, preg_quote($descriptor, static::DESCRIPTOR_REG_EXP_DELIMITER)
        );

        preg_match($regExp, $this->reflection->getDocComment(), $matches);

        return empty($matches) ? null : $matches[1];
    }

    /**
     * @return bool|self
     * @throws \Exception
     */
    public function getParent()
    {
        $reflection = $this->reflection->getParentClass();

        return $reflection ? new self($reflection->getName()) : false;
    }

    /**
     * @param array $params
     * @return object
     * @throws \Exception
     */
    public function create(array $params = [])
    {
        return $this->reflection->newInstanceArgs($params);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function createWithoutConstructor()
    {
        return $this->reflection->newInstanceWithoutConstructor();
    }
}