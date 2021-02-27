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
namespace GI\Component\Switcher\Factory;

use GI\Component\Factory\Base\AbstractFactory;

use GI\Component\Switcher\Gender\Gender;
use GI\Component\Switcher\OnOff\OnOff;
use GI\Component\Switcher\Salutation\Salutation;
use GI\Component\Switcher\YesNo\YesNo;


use GI\Component\Switcher\Gender\GenderInterface;
use GI\Component\Switcher\OnOff\OnOffInterface;
use GI\Component\Switcher\Salutation\SalutationInterface;
use GI\Component\Switcher\YesNo\YesNoInterface;

/**
 * Class Factory
 * @package GI\Component\Switcher\Factory
 *
 * @method GenderInterface createGender(array $name = [])
 * @method OnOffInterface createOnOff(array $name = [])
 * @method SalutationInterface createSalutation(array $name = [])
 * @method YesNoInterface createYesNo(array $name = [])
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->set(Gender::class)
            ->set(OnOff::class)
            ->set(Salutation::class)
            ->set(YesNo::class);
    }
}