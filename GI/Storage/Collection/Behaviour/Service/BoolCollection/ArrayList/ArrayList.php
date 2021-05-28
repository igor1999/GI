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
namespace GI\Storage\Collection\Behaviour\Service\BoolCollection\ArrayList;

use GI\Storage\Collection\Behaviour\Service\AbstractService;

use GI\Storage\Collection\Behaviour\Service\Parts\Order\Values\ValuesTrait as OrderTrait;
use GI\Storage\Collection\Behaviour\Service\Parts\Unique\ValuesOnlyTrait as UniqueTrait;
use GI\Storage\Collection\Behaviour\Service\Parts\BoolStrict\BoolStrictTrait;

use GI\Storage\Collection\Behaviour\Option\BoolCollection\ArrayList\ArrayListInterface as OptionInterface;

class ArrayList extends AbstractService implements ArrayListInterface
{
    use OrderTrait, UniqueTrait, BoolStrictTrait;


    /**
     * ArrayList constructor.
     * @param OptionInterface|null $option
     */
    public function __construct(OptionInterface $option = null)
    {
        parent::__construct($option);
    }

    /**
     * @return OptionInterface
     */
    protected function createDefaultOption()
    {
        return $this->getGiServiceLocator()->getStorageFactory()->getOptionFactory()->createBoolArrayList();
    }

    /**
     * @return OptionInterface
     */
    protected function getOption()
    {
        /** @var OptionInterface $option */
        $option = parent::getOption();

        return $option;
    }
}