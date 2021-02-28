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
namespace GI\Application\Call;

use GI\Pattern\Closing\ClosingInterface;
use GI\Application\Module\Locator\LocatorInterface as ModuleLocatorInterface;
use GI\Application\Module\Provider\ProviderInterface;
use GI\DI\DIInterface;
use GI\Event\ManagerInterface as EventManagerInterface;
use GI\REST\Route\RouteInterface;

interface CallInterface extends ClosingInterface
{
    /**
     * @param ProviderInterface $provider
     * @return static
     * @throws \Exception
     */
    public function setProvider(ProviderInterface $provider);

    /**
     * @param ModuleLocatorInterface $moduleLocator
     * @return static
     * @throws \Exception
     */
    public function setModuleLocator(ModuleLocatorInterface $moduleLocator);

    /**
     * @return bool
     */
    public function hasDi();

    /**
     * @param DIInterface $di
     * @return static
     * @throws \Exception
     */
    public function setDi(DIInterface $di);

    /**
     * @param DIInterface $di
     * @return bool
     * @throws \Exception
     */
    public function setDiIfNotSet(DIInterface $di);

    /**
     * @return bool
     */
    public function hasEventManager();

    /**
     * @param EventManagerInterface $eventManager
     * @return static
     * @throws \Exception
     */
    public function setEventManager(EventManagerInterface $eventManager);

    /**
     * @param EventManagerInterface $eventManager
     * @return bool
     * @throws \Exception
     */
    public function setEventManagerIfNotSet(EventManagerInterface $eventManager);

    /**
     * @return RouteInterface
     */
    public function getRoute();

    /**
     * @return bool
     */
    public function handle();
}