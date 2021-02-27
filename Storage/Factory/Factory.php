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
namespace GI\Storage\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\Storage\Collection\Behaviour\Option\Factory\Factory as OptionFactory;

use GI\Storage\Collection\BoolCollection\ArrayList\Immutable\Immutable as BoolArrayListImmutable;
use GI\Storage\Collection\BoolCollection\ArrayList\Alterable\Alterable as BoolArrayListAlterable;
use GI\Storage\Collection\BoolCollection\ArrayList\Closable\Closable as BoolArrayListClosable;

use GI\Storage\Collection\BoolCollection\HashSet\Immutable\Immutable as BoolHashSetImmutable;
use GI\Storage\Collection\BoolCollection\HashSet\Alterable\Alterable as BoolHashSetAlterable;
use GI\Storage\Collection\BoolCollection\HashSet\Closable\Closable as BoolHashSetClosable;

use GI\Storage\Collection\ClosureCollection\ArrayList\Immutable\Immutable as ClosureArrayListImmutable;
use GI\Storage\Collection\ClosureCollection\ArrayList\Alterable\Alterable as ClosureArrayListAlterable;
use GI\Storage\Collection\ClosureCollection\ArrayList\Closable\Closable as ClosureArrayListClosable;

use GI\Storage\Collection\ClosureCollection\HashSet\Immutable\Immutable as ClosureHashSetImmutable;
use GI\Storage\Collection\ClosureCollection\HashSet\Alterable\Alterable as ClosureHashSetAlterable;
use GI\Storage\Collection\ClosureCollection\HashSet\Closable\Closable as ClosureHashSetClosable;

use GI\Storage\Collection\FloatCollection\ArrayList\Immutable\Immutable as FloatArrayListImmutable;
use GI\Storage\Collection\FloatCollection\ArrayList\Alterable\Alterable as FloatArrayListAlterable;
use GI\Storage\Collection\FloatCollection\ArrayList\Closable\Closable as FloatArrayListClosable;

use GI\Storage\Collection\FloatCollection\HashSet\Immutable\Immutable as FloatHashSetImmutable;
use GI\Storage\Collection\FloatCollection\HashSet\Alterable\Alterable as FloatHashSetAlterable;
use GI\Storage\Collection\FloatCollection\HashSet\Closable\Closable as FloatHashSetClosable;

use GI\Storage\Collection\IntCollection\ArrayList\Immutable\Immutable as IntArrayListImmutable;
use GI\Storage\Collection\IntCollection\ArrayList\Alterable\Alterable as IntArrayListAlterable;
use GI\Storage\Collection\IntCollection\ArrayList\Closable\Closable as IntArrayListClosable;

use GI\Storage\Collection\IntCollection\HashSet\Immutable\Immutable as IntHashSetImmutable;
use GI\Storage\Collection\IntCollection\HashSet\Alterable\Alterable as IntHashSetAlterable;
use GI\Storage\Collection\IntCollection\HashSet\Closable\Closable as IntHashSetClosable;

use GI\Storage\Collection\MixedCollection\ArrayList\Immutable\Immutable as MixedArrayListImmutable;
use GI\Storage\Collection\MixedCollection\ArrayList\Alterable\Alterable as MixedArrayListAlterable;
use GI\Storage\Collection\MixedCollection\ArrayList\Closable\Closable as MixedArrayListClosable;

use GI\Storage\Collection\MixedCollection\HashSet\Immutable\Immutable as MixedHashSetImmutable;
use GI\Storage\Collection\MixedCollection\HashSet\Alterable\Alterable as MixedHashSetAlterable;
use GI\Storage\Collection\MixedCollection\HashSet\Closable\Closable as MixedHashSetClosable;

use GI\Storage\Collection\ScalarCollection\ArrayList\Immutable\Immutable as ScalarArrayListImmutable;
use GI\Storage\Collection\ScalarCollection\ArrayList\Alterable\Alterable as ScalarArrayListAlterable;
use GI\Storage\Collection\ScalarCollection\ArrayList\Closable\Closable as ScalarArrayListClosable;

use GI\Storage\Collection\ScalarCollection\HashSet\Immutable\Immutable as ScalarHashSetImmutable;
use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\Alterable as ScalarHashSetAlterable;
use GI\Storage\Collection\ScalarCollection\HashSet\Closable\Closable as ScalarHashSetClosable;

use GI\Storage\Collection\StringCollection\ArrayList\Immutable\Immutable as StringArrayListImmutable;
use GI\Storage\Collection\StringCollection\ArrayList\Alterable\Alterable as StringArrayListAlterable;
use GI\Storage\Collection\StringCollection\ArrayList\Closable\Closable as StringArrayListClosable;

use GI\Storage\Collection\StringCollection\HashSet\Immutable\Immutable as StringHashSetImmutable;
use GI\Storage\Collection\StringCollection\HashSet\Alterable\Alterable as StringHashSetAlterable;
use GI\Storage\Collection\StringCollection\HashSet\Closable\Closable as StringHashSetClosable;

use GI\Storage\Tree\Tree;


use GI\Storage\Collection\Behaviour\Option\Factory\FactoryInterface as OptionFactoryInterface;

use GI\Storage\Collection\CollectionInterface;
use GI\Storage\Collection\ClosureCollection\CollectionInterface as ClosureCollectionInterface;

use GI\Storage\Collection\Behaviour\Option\BoolCollection\ArrayList\ArrayListInterface as OptionBoolArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\BoolCollection\HashSet\HashSetInterface as OptionBoolHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\ClosureCollection\HashSet\HashSetInterface as OptionClosureHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\FloatCollection\ArrayList\ArrayListInterface as OptionFloatArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\FloatCollection\HashSet\HashSetInterface as OptionFloatHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\IntCollection\ArrayList\ArrayListInterface as OptionIntArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\IntCollection\HashSet\HashSetInterface as OptionIntHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\MixedCollection\ArrayList\ArrayListInterface as OptionMixedArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\MixedCollection\HashSet\HashSetInterface as OptionMixedHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\ScalarCollection\ArrayList\ArrayListInterface as OptionScalarArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\ScalarCollection\HashSet\HashSetInterface as OptionScalarHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\StringCollection\ArrayList\ArrayListInterface as OptionStringArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\StringCollection\HashSet\HashSetInterface as OptionStringHashSetInterface;

use GI\Storage\Collection\BoolCollection\ArrayList\Immutable\ImmutableInterface as BoolArrayListImmutableInterface;
use GI\Storage\Collection\BoolCollection\ArrayList\Alterable\AlterableInterface as BoolArrayListAlterableInterface;
use GI\Storage\Collection\BoolCollection\ArrayList\Closable\ClosableInterface as BoolArrayListClosableInterface;

use GI\Storage\Collection\BoolCollection\HashSet\Immutable\ImmutableInterface as BoolHashSetImmutableInterface;
use GI\Storage\Collection\BoolCollection\HashSet\Alterable\AlterableInterface as BoolHashSetAlterableInterface;
use GI\Storage\Collection\BoolCollection\HashSet\Closable\ClosableInterface as BoolHashSetClosableInterface;

use GI\Storage\Collection\ClosureCollection\ArrayList\Immutable\ImmutableInterface as ClosureArrayListImmutableInterface;
use GI\Storage\Collection\ClosureCollection\ArrayList\Alterable\AlterableInterface as ClosureArrayListAlterableInterface;
use GI\Storage\Collection\ClosureCollection\ArrayList\Closable\ClosableInterface as ClosureArrayListClosableInterface;

use GI\Storage\Collection\ClosureCollection\HashSet\Immutable\ImmutableInterface as ClosureHashSetImmutableInterface;
use GI\Storage\Collection\ClosureCollection\HashSet\Alterable\AlterableInterface as ClosureHashSetAlterableInterface;
use GI\Storage\Collection\ClosureCollection\HashSet\Closable\ClosableInterface as ClosureHashSetClosableInterface;

use GI\Storage\Collection\FloatCollection\ArrayList\Immutable\ImmutableInterface as FloatArrayListImmutableInterface;
use GI\Storage\Collection\FloatCollection\ArrayList\Alterable\AlterableInterface as FloatArrayListAlterableInterface;
use GI\Storage\Collection\FloatCollection\ArrayList\Closable\ClosableInterface as FloatArrayListClosableInterface;

use GI\Storage\Collection\FloatCollection\HashSet\Immutable\ImmutableInterface as FloatHashSetImmutableInterface;
use GI\Storage\Collection\FloatCollection\HashSet\Alterable\AlterableInterface as FloatHashSetAlterableInterface;
use GI\Storage\Collection\FloatCollection\HashSet\Closable\ClosableInterface as FloatHashSetClosableInterface;

use GI\Storage\Collection\IntCollection\ArrayList\Immutable\ImmutableInterface as IntArrayListImmutableInterface;
use GI\Storage\Collection\IntCollection\ArrayList\Alterable\AlterableInterface as IntArrayListAlterableInterface;
use GI\Storage\Collection\IntCollection\ArrayList\Closable\ClosableInterface as IntArrayListClosableInterface;

use GI\Storage\Collection\IntCollection\HashSet\Immutable\ImmutableInterface as IntHashSetImmutableInterface;
use GI\Storage\Collection\IntCollection\HashSet\Alterable\AlterableInterface as IntHashSetAlterableInterface;
use GI\Storage\Collection\IntCollection\HashSet\Closable\ClosableInterface as IntHashSetClosableInterface;

use GI\Storage\Collection\MixedCollection\ArrayList\Immutable\ImmutableInterface as MixedArrayListImmutableInterface;
use GI\Storage\Collection\MixedCollection\ArrayList\Alterable\AlterableInterface as MixedArrayListAlterableInterface;
use GI\Storage\Collection\MixedCollection\ArrayList\Closable\ClosableInterface as MixedArrayListClosableInterface;

use GI\Storage\Collection\MixedCollection\HashSet\Immutable\ImmutableInterface as MixedHashSetImmutableInterface;
use GI\Storage\Collection\MixedCollection\HashSet\Alterable\AlterableInterface as MixedHashSetAlterableInterface;
use GI\Storage\Collection\MixedCollection\HashSet\Closable\ClosableInterface as MixedHashSetClosableInterface;

use GI\Storage\Collection\ScalarCollection\ArrayList\Immutable\ImmutableInterface as ScalarArrayListImmutableInterface;
use GI\Storage\Collection\ScalarCollection\ArrayList\Alterable\AlterableInterface as ScalarArrayListAlterableInterface;
use GI\Storage\Collection\ScalarCollection\ArrayList\Closable\ClosableInterface as ScalarArrayListClosableInterface;

use GI\Storage\Collection\ScalarCollection\HashSet\Immutable\ImmutableInterface as ScalarHashSetImmutableInterface;
use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\AlterableInterface as ScalarHashSetAlterableInterface;
use GI\Storage\Collection\ScalarCollection\HashSet\Closable\ClosableInterface as ScalarHashSetClosableInterface;

use GI\Storage\Collection\StringCollection\ArrayList\Immutable\ImmutableInterface as StringArrayListImmutableInterface;
use GI\Storage\Collection\StringCollection\ArrayList\Alterable\AlterableInterface as StringArrayListAlterableInterface;
use GI\Storage\Collection\StringCollection\ArrayList\Closable\ClosableInterface as StringArrayListClosableInterface;

use GI\Storage\Collection\StringCollection\HashSet\Immutable\ImmutableInterface as StringHashSetImmutableInterface;
use GI\Storage\Collection\StringCollection\HashSet\Alterable\AlterableInterface as StringHashSetAlterableInterface;
use GI\Storage\Collection\StringCollection\HashSet\Closable\ClosableInterface as StringHashSetClosableInterface;

use GI\Storage\Tree\TreeInterface;

/**
 * Class Factory
 * @package GI\Storage\Factory
 *
 * @method BoolArrayListImmutableInterface createBoolArrayListImmutable(array $items = [], OptionBoolArrayListInterface $option = null)
 * @method BoolArrayListAlterableInterface createBoolArrayListAlterable(array $items = [], OptionBoolArrayListInterface $option = null)
 * @method BoolArrayListClosableInterface createBoolArrayListClosable(array $items = [], OptionBoolArrayListInterface $option = null)
 *
 * @method BoolHashSetImmutableInterface createBoolHashSetImmutable(array $items = [], OptionBoolHashSetInterface $option = null)
 * @method BoolHashSetAlterableInterface createBoolHashSetAlterable(array $items = [], OptionBoolHashSetInterface $option = null)
 * @method BoolHashSetClosableInterface createBoolHashSetClosable(array $items = [], OptionBoolHashSetInterface $option = null)
 *
 * @method ClosureArrayListImmutableInterface createClosureArrayListImmutable(array $items = [])
 * @method ClosureArrayListAlterableInterface createClosureArrayListAlterable(array $items = [])
 * @method ClosureArrayListClosableInterface createClosureArrayListClosable(array $items = [])
 *
 * @method ClosureHashSetImmutableInterface createClosureHashSetImmutable(array $items = [], OptionClosureHashSetInterface $option = null)
 * @method ClosureHashSetAlterableInterface createClosureHashSetAlterable(array $items = [], OptionClosureHashSetInterface $option = null)
 * @method ClosureHashSetClosableInterface createClosureHashSetClosable(array $items = [], OptionClosureHashSetInterface $option = null)
 *
 * @method FloatArrayListImmutableInterface createFloatArrayListImmutable(array $items = [], OptionFloatArrayListInterface $option = null)
 * @method FloatArrayListAlterableInterface createFloatArrayListAlterable(array $items = [], OptionFloatArrayListInterface $option = null)
 * @method FloatArrayListClosableInterface createFloatArrayListClosable(array $items = [], OptionFloatArrayListInterface $option = null)
 *
 * @method FloatHashSetImmutableInterface createFloatHashSetImmutable(array $items = [], OptionFloatHashSetInterface $option = null)
 * @method FloatHashSetAlterableInterface createFloatHashSetAlterable(array $items = [], OptionFloatHashSetInterface $option = null)
 * @method FloatHashSetClosableInterface createFloatHashSetClosable(array $items = [], OptionFloatHashSetInterface $option = null)
 *
 * @method IntArrayListImmutableInterface createIntArrayListImmutable(array $items = [], OptionIntArrayListInterface $option = null)
 * @method IntArrayListAlterableInterface createIntArrayListAlterable(array $items = [], OptionIntArrayListInterface $option = null)
 * @method IntArrayListClosableInterface createIntArrayListClosable(array $items = [], OptionIntArrayListInterface $option = null)
 *
 * @method IntHashSetImmutableInterface createIntHashSetImmutable(array $items = [], OptionIntHashSetInterface $option = null)
 * @method IntHashSetAlterableInterface createIntHashSetAlterable(array $items = [], OptionIntHashSetInterface $option = null)
 * @method IntHashSetClosableInterface createIntHashSetClosable(array $items = [], OptionIntHashSetInterface $option = null)
 *
 * @method MixedArrayListImmutableInterface createMixedArrayListImmutable(array $items = [], OptionMixedArrayListInterface $option = null)
 * @method MixedArrayListAlterableInterface createMixedArrayListAlterable(array $items = [], OptionMixedArrayListInterface $option = null)
 * @method MixedArrayListClosableInterface createMixedArrayListClosable(array $items = [], OptionMixedArrayListInterface $option = null)
 *
 * @method MixedHashSetImmutableInterface createMixedHashSetImmutable(array $items = [], OptionMixedHashSetInterface $option = null)
 * @method MixedHashSetAlterableInterface createMixedHashSetAlterable(array $items = [], OptionMixedHashSetInterface $option = null)
 * @method MixedHashSetClosableInterface createMixedHashSetClosable(array $items = [], OptionMixedHashSetInterface $option = null)
 *
 * @method ScalarArrayListImmutableInterface createScalarArrayListImmutable(array $items = [], OptionScalarArrayListInterface $option = null)
 * @method ScalarArrayListAlterableInterface createScalarArrayListAlterable(array $items = [], OptionScalarArrayListInterface $option = null)
 * @method ScalarArrayListClosableInterface createScalarArrayListClosable(array $items = [], OptionScalarArrayListInterface $option = null)
 *
 * @method ScalarHashSetImmutableInterface createScalarHashSetImmutable(array $items = [], OptionScalarHashSetInterface $option = null)
 * @method ScalarHashSetAlterableInterface createScalarHashSetAlterable(array $items = [], OptionScalarHashSetInterface $option = null)
 * @method ScalarHashSetClosableInterface createScalarHashSetClosable(array $items = [], OptionScalarHashSetInterface $option = null)
 *
 * @method StringArrayListImmutableInterface createStringArrayListImmutable(array $items = [], OptionStringArrayListInterface $option = null)
 * @method StringArrayListAlterableInterface createStringArrayListAlterable(array $items = [], OptionStringArrayListInterface $option = null)
 * @method StringArrayListClosableInterface createStringArrayListClosable(array $items = [], OptionStringArrayListInterface $option = null)
 *
 * @method StringHashSetImmutableInterface createStringHashSetImmutable(array $items = [], OptionStringHashSetInterface $option = null)
 * @method StringHashSetAlterableInterface createStringHashSetAlterable(array $items = [], OptionStringHashSetInterface $option = null)
 * @method StringHashSetClosableInterface createStringHashSetClosable(array $items = [], OptionStringHashSetInterface $option = null)
 *
 * @method TreeInterface createTree(array $nodes = [])
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * @var OptionFactoryInterface
     */
    private $optionFactory;


    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()
            ->add(TreeInterface::class)
            ->add(CollectionInterface::class)
            ->add(ClosureCollectionInterface::class);

        $this->setNamed('BoolArrayListImmutable', BoolArrayListImmutable::class)
            ->setNamed('BoolArrayListAlterable', BoolArrayListAlterable::class)
            ->setNamed('BoolArrayListClosable', BoolArrayListClosable::class)
            
            ->setNamed('BoolHashSetImmutable', BoolHashSetImmutable::class)
            ->setNamed('BoolHashSetAlterable', BoolHashSetAlterable::class)
            ->setNamed('BoolHashSetClosable', BoolHashSetClosable::class)

            ->setNamed('ClosureArrayListImmutable', ClosureArrayListImmutable::class)
            ->setNamed('ClosureArrayListAlterable', ClosureArrayListAlterable::class)
            ->setNamed('ClosureArrayListClosable', ClosureArrayListClosable::class)

            ->setNamed('ClosureHashSetImmutable', ClosureHashSetImmutable::class)
            ->setNamed('ClosureHashSetAlterable', ClosureHashSetAlterable::class)
            ->setNamed('ClosureHashSetClosable', ClosureHashSetClosable::class)

            ->setNamed('FloatArrayListImmutable', FloatArrayListImmutable::class)
            ->setNamed('FloatArrayListAlterable', FloatArrayListAlterable::class)
            ->setNamed('FloatArrayListClosable', FloatArrayListClosable::class)

            ->setNamed('FloatHashSetImmutable', FloatHashSetImmutable::class)
            ->setNamed('FloatHashSetAlterable', FloatHashSetAlterable::class)
            ->setNamed('FloatHashSetClosable', FloatHashSetClosable::class)
            
            ->setNamed('IntArrayListImmutable', IntArrayListImmutable::class)
            ->setNamed('IntArrayListAlterable', IntArrayListAlterable::class)
            ->setNamed('IntArrayListClosable', IntArrayListClosable::class)

            ->setNamed('IntHashSetImmutable', IntHashSetImmutable::class)
            ->setNamed('IntHashSetAlterable', IntHashSetAlterable::class)
            ->setNamed('IntHashSetClosable', IntHashSetClosable::class)

            ->setNamed('MixedArrayListImmutable', MixedArrayListImmutable::class)
            ->setNamed('MixedArrayListAlterable', MixedArrayListAlterable::class)
            ->setNamed('MixedArrayListClosable', MixedArrayListClosable::class)

            ->setNamed('MixedHashSetImmutable', MixedHashSetImmutable::class)
            ->setNamed('MixedHashSetAlterable', MixedHashSetAlterable::class)
            ->setNamed('MixedHashSetClosable', MixedHashSetClosable::class)

            ->setNamed('ScalarArrayListImmutable', ScalarArrayListImmutable::class)
            ->setNamed('ScalarArrayListAlterable', ScalarArrayListAlterable::class)
            ->setNamed('ScalarArrayListClosable', ScalarArrayListClosable::class)

            ->setNamed('ScalarHashSetImmutable', ScalarHashSetImmutable::class)
            ->setNamed('ScalarHashSetAlterable', ScalarHashSetAlterable::class)
            ->setNamed('ScalarHashSetClosable', ScalarHashSetClosable::class)

            ->setNamed('StringArrayListImmutable', StringArrayListImmutable::class)
            ->setNamed('StringArrayListAlterable', StringArrayListAlterable::class)
            ->setNamed('StringArrayListClosable', StringArrayListClosable::class)

            ->setNamed('StringHashSetImmutable', StringHashSetImmutable::class)
            ->setNamed('StringHashSetAlterable', StringHashSetAlterable::class)
            ->setNamed('StringHashSetClosable', StringHashSetClosable::class)

            ->set(Tree::class);
    }

    /**
     * @return OptionFactoryInterface
     */
    public function getOptionFactory()
    {
        if (!($this->optionFactory instanceof OptionFactoryInterface)) {
            $this->optionFactory = new OptionFactory();
        }

        return $this->optionFactory;
    }
}