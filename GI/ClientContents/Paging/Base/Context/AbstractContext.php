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
namespace GI\ClientContents\Paging\Base\Context;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Validation\ValidationTrait;

use GI\Storage\Collection\IntCollection\ArrayList\Alterable\AlterableInterface as SizesInterface;

abstract class AbstractContext implements ContextInterface
{
    use ServiceLocatorAwareTrait, ValidationTrait;


    const DEFAULT_SIZES = [10, 20, 50, 100];


    /**
     * @var SizesInterface
     */
    private $sizes;


    /**
     * AbstractContext constructor.
     */
    public function __construct()
    {
        $option = $this->giGetStorageFactory()->getOptionFactory()->createIntArrayList();
        $option->setOrdered(true)->setUnique(true)->setMin(10);

        $this->sizes = $this->giGetStorageFactory()->createIntArrayListAlterable(static::DEFAULT_SIZES, $option);
    }

    /**
     * @return SizesInterface
     */
    public function getSizes()
    {
        return $this->sizes;
    }
}