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
namespace GI\ClientContents\Selection\Factory;

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\ClientContents\Selection\Single\AlterableSingleInterface;
use GI\ClientContents\Selection\Multi\AlterableMultiInterface;
use GI\ClientContents\Selection\Universal\AlterableUniversalInterface;

use GI\ClientContents\Selection\Advanced\Gender\GenderInterface;
use GI\ClientContents\Selection\Advanced\OnOff\OnOffInterface;
use GI\ClientContents\Selection\Advanced\Salutation\SalutationInterface;
use GI\ClientContents\Selection\Advanced\YesNo\YesNoInterface;

/**
 * Interface FactoryInterface
 * @package GI\ClientContents\Selection\Factory
 *
 * @method AlterableSingleInterface createAlterableSingle()
 * @method AlterableMultiInterface createAlterableMulti()
 * @method AlterableUniversalInterface createAlterableUniversal()
 *
 * @method GenderInterface createGender()
 * @method OnOffInterface createOnOff()
 * @method SalutationInterface createSalutation()
 * @method YesNoInterface createYesNo()
 */
interface FactoryInterface extends BaseInterface
{

}