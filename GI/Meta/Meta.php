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
namespace GI\Meta;

use GI\Meta\ClassMeta\Factory\Factory as ClassMetaFactory;
use GI\Meta\ClassMeta\Collection\Alterable as ClassMetaCollection;
use GI\Meta\Method\Collection\Alterable as MethodCollection;
use GI\Meta\Property\Collection\Alterable as PropertyCollection;
use GI\Meta\CopyMaker\CopyMaker;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Meta\ClassMeta\Factory\FactoryInterface as ClassMetaFactoryInterface;
use GI\Meta\ClassMeta\ClassMetaInterface;
use GI\Meta\ClassMeta\Collection\AlterableInterface as ClassMetaCollectionInterface;
use GI\Meta\Method\Collection\AlterableInterface as MethodCollectionInterface;
use GI\Meta\Property\Collection\AlterableInterface as PropertyCollectionInterface;
use GI\Meta\Method\MethodInterface;
use GI\Meta\Property\PropertyInterface;
use GI\Meta\CopyMaker\CopyMakerInterface;

class Meta implements MetaInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ClassMetaFactoryInterface
     */
    private $classMetaFactory;

    /**
     * @var CopyMakerInterface
     */
    private $copyMaker;


    /**
     * Meta constructor.
     */
    public function __construct()
    {
        $this->classMetaFactory = $this->createClassMetaFactory();
    }

    /**
     * @return ClassMetaFactoryInterface
     */
    protected function getClassMetaFactory()
    {
        return $this->classMetaFactory;
    }

    /**
     * @return ClassMetaFactory
     */
    protected function createClassMetaFactory()
    {
        return new ClassMetaFactory();
    }

    /**
     * @param mixed $source
     * @return bool
     */
    public function hasClassMeta($source)
    {
        return $this->getClassMetaFactory()->has($source);
    }

    /**
     * @param mixed $source
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function getClassMeta($source)
    {
        return $this->getClassMetaFactory()->get($source);
    }

    /**
     * @param array $items
     * @return ClassMetaCollectionInterface
     * @throws \Exception
     */
    public function createClassMetaCollection(array $items = [])
    {
        return new ClassMetaCollection($items);
    }

    /**
     * @param MethodInterface[] $items
     * @return MethodCollectionInterface
     */
    public function createMethodCollection(array $items = [])
    {
        return new MethodCollection($items);
    }

    /**
     * @param PropertyInterface[] $items
     * @return PropertyCollectionInterface
     */
    public function createPropertyCollection(array $items = [])
    {
        return new PropertyCollection($items);
    }

    /**
     * @param string|null $caller
     * @return CopyMakerInterface
     */
    public function getCopyMaker(string $caller = null)
    {
        try {
            $result = $this->giGetServiceLocator()->getDi()->find(CopyMakerInterface::class, $caller);
        } catch (\Exception $exception) {
            if (!($this->copyMaker instanceof CopyMakerInterface)) {
                $this->copyMaker = new CopyMaker();
            }

            $result = $this->copyMaker;
        }

        return $result;
    }
}