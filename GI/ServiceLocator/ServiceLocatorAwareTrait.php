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

use GI\ServiceLocator\AwareTraits\CLIAwareTrait;
use GI\ServiceLocator\AwareTraits\DIAwareTrait;
use GI\ServiceLocator\AwareTraits\ExceptionAwareTrait;
use GI\ServiceLocator\AwareTraits\FileSystemAwareTrait;
use GI\ServiceLocator\AwareTraits\FilterValidatorAwareTrait;
use GI\ServiceLocator\AwareTraits\I18nAwareTrait;
use GI\ServiceLocator\AwareTraits\IdentityAwareTrait;
use GI\ServiceLocator\AwareTraits\JsonAwareTrait;
use GI\ServiceLocator\AwareTraits\MetaAwareTrait;
use GI\ServiceLocator\AwareTraits\MiscAwareTrait;
use GI\ServiceLocator\AwareTraits\RDBAwareTrait;
use GI\ServiceLocator\AwareTraits\RESTAwareTrait;
use GI\ServiceLocator\AwareTraits\SecurityAwareTrait;
use GI\ServiceLocator\AwareTraits\UtilAwareTrait;
use GI\ServiceLocator\AwareTraits\ViewAwareTrait;

trait ServiceLocatorAwareTrait
{
    use CLIAwareTrait,
        DIAwareTrait,
        ExceptionAwareTrait,
        FileSystemAwareTrait,
        FilterValidatorAwareTrait,
        I18nAwareTrait,
        IdentityAwareTrait,
        JsonAwareTrait,
        MetaAwareTrait,
        MiscAwareTrait,
        RDBAwareTrait,
        RESTAwareTrait,
        SecurityAwareTrait,
        UtilAwareTrait,
        ViewAwareTrait;


    /**
     * @return ServiceLocatorInterface
     */
    protected function giGetServiceLocator()
    {
        return ServiceLocator::getInstance();
    }
}