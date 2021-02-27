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
namespace GI\Application\Application\Complex\CLI;

use GI\Application\Application\AbstractApplication;

use GI\Application\Application\Base\ComplexTrait;
use GI\Application\Application\Base\CLITrait;

use GI\Application\Module\Locator\LocatorInterface as ModuleLocatorInterface;

class Application extends AbstractApplication implements ApplicationInterface
{
    use CLITrait, ComplexTrait;


    /**
     * Application constructor.
     * @param ModuleLocatorInterface $moduleLocator
     */
    public function __construct(ModuleLocatorInterface $moduleLocator)
    {
        parent::__construct();

        $this->moduleLocator = $moduleLocator;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function run()
    {
        $found = false;

        foreach ($this->getModuleLocator()->getCLICalls() as $call) {
            $found = $call->handle();

            if ($found) {
                break;
            }
        }

        if (!$found) {
            $this->handleDefault();
        }

        return $found;
    }
}