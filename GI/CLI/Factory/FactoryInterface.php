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
namespace GI\CLI\Factory;

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\CLI\CommandLine\Argument\ArgumentInterface as ArgumentsItemInterface;
use GI\CLI\CommandLine\CommandLineInterface;
use GI\CLI\Colorizing\ColorizingInterface;
use GI\CLI\Input\Password\PasswordInterface as InputPasswordInterface;
use GI\CLI\Input\Simple\SimpleInterface as InputSimpleInterface;
use GI\CLI\Input\YesNo\YesNoInterface as InputYesNoInterface;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

/**
 * Interface FactoryInterface
 * @package GI\CLI\Factory
 *
 * @method ArgumentsItemInterface createArgumentsItem(string $raw = '')
 * @method CommandLineInterface createCommandLine(array $items = [], FSOFileInterface $script = null)
 * @method ColorizingInterface createColorizing()
 * @method InputPasswordInterface createInputPassword()
 * @method InputSimpleInterface createInputSimple()
 * @method InputYesNoInterface createInputYesNo()
 */
interface FactoryInterface extends BaseInterface
{

}