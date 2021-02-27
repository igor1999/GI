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

use GI\Pattern\Factory\AbstractFactory;

use GI\ClientContents\Selection\Single\AlterableSingle;
use GI\ClientContents\Selection\Multi\AlterableMulti;
use GI\ClientContents\Selection\Universal\AlterableUniversal;

use GI\ClientContents\Selection\Advanced\Gender\Gender;
use GI\ClientContents\Selection\Advanced\OnOff\OnOff;
use GI\ClientContents\Selection\Advanced\Salutation\Salutation;
use GI\ClientContents\Selection\Advanced\YesNo\YesNo;


use GI\ClientContents\Selection\ImmutableInterface;

use GI\ClientContents\Selection\Single\AlterableSingleInterface;
use GI\ClientContents\Selection\Multi\AlterableMultiInterface;
use GI\ClientContents\Selection\Universal\AlterableUniversalInterface;

use GI\ClientContents\Selection\Advanced\Gender\GenderInterface;
use GI\ClientContents\Selection\Advanced\OnOff\OnOffInterface;
use GI\ClientContents\Selection\Advanced\Salutation\SalutationInterface;
use GI\ClientContents\Selection\Advanced\YesNo\YesNoInterface;

/**
 * Class Factory
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
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(ImmutableInterface::class);

        $this->set(AlterableSingle::class, true)
            ->set(AlterableMulti::class)
            ->set(AlterableUniversal::class)

            ->set(Gender::class)
            ->set(OnOff::class)
            ->set(Salutation::class)
            ->set(YesNo::class);
    }
}