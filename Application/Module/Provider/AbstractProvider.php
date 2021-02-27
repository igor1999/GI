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
namespace GI\Application\Module\Provider;

use GI\DI\DI;
use GI\Application\Module\CallContainer\Web\Web as WebCallContainer;
use GI\Application\Module\CallContainer\CLI\CLI as CLICallContainer;
use GI\Event\Manager as EventManager;

use GI\Application\Module\CallContainer\Web\WebInterface as WebCallContainerInterface;
use GI\Application\Module\CallContainer\CLI\CLIInterface as CLICallContainerInterface;
use GI\DI\DIInterface;
use GI\Event\ManagerInterface as EventManagerInterface;

abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @return WebCallContainerInterface
     */
    public function getWebCallContainer()
    {
        return new WebCallContainer();
    }

    /**
     * @return CLICallContainerInterface
     */
    public function getCLICallContainer()
    {
        return new CLICallContainer();
    }

    /**
     * @return DIInterface
     */
    public function getDI()
    {
        return new DI();
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return new EventManager();
    }

    /**
     * @return string[]
     */
    public function getSessionExchangeClasses()
    {
        return [];
    }
}