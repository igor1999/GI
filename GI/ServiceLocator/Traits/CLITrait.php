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
namespace GI\ServiceLocator\Traits;

use GI\CLI\Factory\Factory as CLIFactory;

use GI\CLI\Factory\FactoryInterface as CLIFactoryInterface;
use GI\ServiceLocator\ServiceLocatorInterface;

trait CLITrait
{
    /**
     * @var CLIFactoryInterface
     */
    private $cliFactory;

    /**
     * @var bool
     */
    private $isCLI = false;


    /**
     * @param string|null $caller
     * @return CLIFactoryInterface
     */
    public function getCLIFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(CLIFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->cliFactory instanceof CLIFactoryInterface)) {
                $this->cliFactory = new CLIFactory();
            }

            $result = $this->cliFactory;
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isCLI()
    {
        return $this->isCLI;
    }
}