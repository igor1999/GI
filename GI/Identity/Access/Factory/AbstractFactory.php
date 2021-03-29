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
namespace GI\Identity\Access\Factory;

use GI\Pattern\Factory\AbstractFactory as Base;
use GI\Identity\Access\Profile;

use GI\Identity\Access\ProfileInterface;

/**
 * Class AbstractFactory
 * @package GI\Identity\Access\Factory
 *
 * @method ProfileInterface getCommon()
 */
class AbstractFactory extends Base implements FactoryInterface
{
    /**
     * AbstractFactory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(ProfileInterface::class);

        $this->setPrefixToGet()->setCached(true);

        $this->setNamed('Common', Profile::class);
    }
}