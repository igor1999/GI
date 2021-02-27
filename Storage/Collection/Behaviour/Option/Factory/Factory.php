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
namespace GI\Storage\Collection\Behaviour\Option\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\Storage\Collection\Behaviour\Option\BoolCollection\ArrayList\ArrayList as BoolArrayList;
use GI\Storage\Collection\Behaviour\Option\BoolCollection\HashSet\HashSet as BoolHashSet;

use GI\Storage\Collection\Behaviour\Option\ClosureCollection\HashSet\HashSet as ClosureHashSet;

use GI\Storage\Collection\Behaviour\Option\MixedCollection\ArrayList\ArrayList as MixedArrayList;
use GI\Storage\Collection\Behaviour\Option\MixedCollection\HashSet\HashSet as MixedHashSet;

use GI\Storage\Collection\Behaviour\Option\ScalarCollection\ArrayList\ArrayList as ScalarArrayList;
use GI\Storage\Collection\Behaviour\Option\ScalarCollection\HashSet\HashSet as ScalarHashSet;

use GI\Storage\Collection\Behaviour\Option\FloatCollection\ArrayList\ArrayList as FloatArrayList;
use GI\Storage\Collection\Behaviour\Option\FloatCollection\HashSet\HashSet as FloatHashSet;

use GI\Storage\Collection\Behaviour\Option\IntCollection\ArrayList\ArrayList as IntArrayList;
use GI\Storage\Collection\Behaviour\Option\IntCollection\HashSet\HashSet as IntHashSet;

use GI\Storage\Collection\Behaviour\Option\StringCollection\ArrayList\ArrayList as StringArrayList;
use GI\Storage\Collection\Behaviour\Option\StringCollection\HashSet\HashSet as StringHashSet;


use GI\Storage\Collection\Behaviour\Option\OptionInterface;

use GI\Storage\Collection\Behaviour\Option\BoolCollection\ArrayList\ArrayListInterface as BoolArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\BoolCollection\HashSet\HashSetInterface as BoolHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\ClosureCollection\HashSet\HashSetInterface as ClosureHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\MixedCollection\ArrayList\ArrayListInterface as MixedArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\MixedCollection\HashSet\HashSetInterface as MixedHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\ScalarCollection\ArrayList\ArrayListInterface as ScalarArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\ScalarCollection\HashSet\HashSetInterface as ScalarHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\FloatCollection\ArrayList\ArrayListInterface as FloatArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\FloatCollection\HashSet\HashSetInterface as FloatHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\IntCollection\ArrayList\ArrayListInterface as IntArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\IntCollection\HashSet\HashSetInterface as IntHashSetInterface;

use GI\Storage\Collection\Behaviour\Option\StringCollection\ArrayList\ArrayListInterface as StringArrayListInterface;
use GI\Storage\Collection\Behaviour\Option\StringCollection\HashSet\HashSetInterface as StringHashSetInterface;

/**
 * Class Factory
 * @package GI\Storage\Collection\Behaviour\Option\Factory
 *
 * @method BoolArrayListInterface createBoolArrayList()
 * @method BoolHashSetInterface createBoolHashSet()
 *
 * @method ClosureHashSetInterface createClosureHashSet()
 *
 * @method MixedArrayListInterface createMixedArrayList()
 * @method MixedHashSetInterface createMixedHashSet()
 *
 * @method ScalarArrayListInterface createScalarArrayList()
 * @method ScalarHashSetInterface createScalarHashSet()
 *
 * @method FloatArrayListInterface createFloatArrayList()
 * @method FloatHashSetInterface createFloatHashSet()
 *
 * @method IntArrayListInterface createIntArrayList()
 * @method IntHashSetInterface createIntHashSet()
 *
 * @method StringArrayListInterface createStringArrayList()
 * @method StringHashSetInterface createStringHashSet()
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(OptionInterface::class);

        $this->setNamed('BoolArrayList', BoolArrayList::class)
            ->setNamed('BoolHashSet', BoolHashSet::class)

            ->setNamed('ClosureHashSet', ClosureHashSet::class)

            ->setNamed('MixedArrayList', MixedArrayList::class)
            ->setNamed('MixedHashSet', MixedHashSet::class)

            ->setNamed('ScalarArrayList', ScalarArrayList::class)
            ->setNamed('ScalarHashSet', ScalarHashSet::class)

            ->setNamed('FloatArrayList', FloatArrayList::class)
            ->setNamed('FloatHashSet', FloatHashSet::class)

            ->setNamed('IntArrayList', IntArrayList::class)
            ->setNamed('IntHashSet', IntHashSet::class)

            ->setNamed('StringArrayList', StringArrayList::class)
            ->setNamed('StringHashSet', StringHashSet::class);
    }
}