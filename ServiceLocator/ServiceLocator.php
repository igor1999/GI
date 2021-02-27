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

use GI\Pattern\Closing\ClosingTrait;
use GI\ServiceLocator\Traits\CLITrait;
use GI\ServiceLocator\Traits\DebuggingTrait;
use GI\ServiceLocator\Traits\DITrait;
use GI\ServiceLocator\Traits\EventManagerTrait;
use GI\ServiceLocator\Traits\ExceptionTrait;
use GI\ServiceLocator\Traits\FileSystemTrait;
use GI\ServiceLocator\Traits\FilterValidatorTrait;
use GI\ServiceLocator\Traits\I18nTrait;
use GI\ServiceLocator\Traits\IdentityTrait;
use GI\ServiceLocator\Traits\JsonTrait;
use GI\ServiceLocator\Traits\MetaTrait;
use GI\ServiceLocator\Traits\MiscTrait;
use GI\ServiceLocator\Traits\RDBTrait;
use GI\ServiceLocator\Traits\RESTTrait;
use GI\ServiceLocator\Traits\SecurityTrait;
use GI\ServiceLocator\Traits\SessionExchangeTrait;
use GI\ServiceLocator\Traits\UtilTrait;
use GI\ServiceLocator\Traits\ViewTrait;

class ServiceLocator implements ServiceLocatorInterface
{
    use ClosingTrait,
        CLITrait,
        DebuggingTrait,
        DITrait,
        ExceptionTrait,
        EventManagerTrait,
        FileSystemTrait,
        FilterValidatorTrait,
        I18nTrait,
        IdentityTrait,
        JsonTrait,
        MetaTrait,
        MiscTrait,
        RDBTrait,
        RESTTrait,
        SecurityTrait,
        SessionExchangeTrait,
        UtilTrait,
        ViewTrait;


    /**
     * @var ServiceLocatorInterface
     */
    private static $singleton;


    /**
     * ServiceLocator constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->isCLI = defined('STDOUT') && is_resource(STDOUT);

        $f = function($errorNumber, $errorMessage, $errorFile, $errorLine)
        {
            $this->createHandler()->handleError($errorNumber, $errorMessage, $errorFile, $errorLine);
        };
        set_error_handler($f);
    }

    /**
     * @return ServiceLocatorInterface
     */
    public static function getInstance()
    {
        if (!(self::$singleton instanceof ServiceLocatorInterface)) {
            self::$singleton = new self();
        }

        return self::$singleton;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setExceptionHandler()
    {
        $this->validateClosing();

        $f = function(\Throwable $throwable)
        {
            $this->createHandler()->handleThrowable($throwable);
        };
        set_exception_handler($f);

        return $this;
    }
}