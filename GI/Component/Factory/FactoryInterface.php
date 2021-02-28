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
namespace GI\Component\Factory;

use GI\Component\Factory\Base\FactoryInterface as BaseInterface;

use GI\Component\Captcha\Factory\FactoryInterface as CaptchaFactoryInterface;
use GI\Component\Error\Factory\FactoryInterface as ErrorFactoryInterface;
use GI\Component\Paging\Factory\FactoryInterface as PagingFactoryInterface;
use GI\Component\Switcher\Factory\FactoryInterface as SwitcherFactoryInterface;

use GI\Component\Authentication\Login\LoginInterface;
use GI\Component\Authentication\Login\Dialog\DialogInterface;
use GI\Component\Authentication\Logout\LogoutInterface;
use GI\Component\Authentication\AuthenticationInterface;

use GI\Component\Locales\LocalesInterface;

/**
 * Interface FactoryInterface
 * @package GI\Component\Factory
 *
 * @method LoginInterface createLogin()
 * @method DialogInterface createLoginDialog()
 * @method LogoutInterface createLogout()
 * @method AuthenticationInterface createAuthentication()
 * @method LocalesInterface createLocales()
 */
interface FactoryInterface extends BaseInterface
{
    /**
     * @return CaptchaFactoryInterface
     */
    public function getCaptchaFactory();

    /**
     * @return ErrorFactoryInterface
     */
    public function getErrorFactory();

    /**
     * @return PagingFactoryInterface
     */
    public function getPagingFactory();

    /**
     * @return SwitcherFactoryInterface
     */
    public function getSwitcherFactory();
}