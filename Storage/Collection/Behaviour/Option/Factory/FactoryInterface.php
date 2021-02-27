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

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

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
 * Interface FactoryInterface
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
interface FactoryInterface extends BaseInterface
{

}