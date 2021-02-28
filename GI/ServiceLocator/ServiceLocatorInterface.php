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
namespace GI\ServiceLocator;

use GI\Pattern\Closing\ClosingInterface;
use GI\ServiceLocator\Interfaces\CLIInterface;
use GI\ServiceLocator\Interfaces\DIInterface;
use GI\ServiceLocator\Interfaces\EventManagerInterface;
use GI\ServiceLocator\Interfaces\ExceptionInterface;
use GI\ServiceLocator\Interfaces\FileSystemInterface;
use GI\ServiceLocator\Interfaces\FilterValidatorInterface;
use GI\ServiceLocator\Interfaces\I18nInterface;
use GI\ServiceLocator\Interfaces\IdentityInterface;
use GI\ServiceLocator\Interfaces\JsonInterface;
use GI\ServiceLocator\Interfaces\MetaInterface;
use GI\ServiceLocator\Interfaces\MiscInterface;
use GI\ServiceLocator\Interfaces\RDBInterface;
use GI\ServiceLocator\Interfaces\RESTInterface;
use GI\ServiceLocator\Interfaces\SecurityInterface;
use GI\ServiceLocator\Interfaces\SessionExchangeInterface;
use GI\ServiceLocator\Interfaces\UtilInterface;
use GI\ServiceLocator\Interfaces\ViewInterface;

interface ServiceLocatorInterface extends
    ClosingInterface,
    CLIInterface,
    DIInterface,
    ExceptionInterface,
    EventManagerInterface,
    FileSystemInterface,
    FilterValidatorInterface,
    I18nInterface,
    IdentityInterface,
    JsonInterface,
    MetaInterface,
    MiscInterface,
    RDBInterface,
    RESTInterface,
    SecurityInterface,
    SessionExchangeInterface,
    UtilInterface,
    ViewInterface
{
    /**
     * @return ServiceLocatorInterface
     */
    public static function getInstance();

    /**
     * @return static
     * @throws \Exception
     */
    public function setExceptionHandler();
}