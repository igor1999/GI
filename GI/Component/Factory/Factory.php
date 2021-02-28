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

use GI\Component\Factory\Base\AbstractFactory;

use GI\Component\Captcha\Factory\Factory as CaptchaFactory;
use GI\Component\Error\Factory\Factory as ErrorFactory;
use GI\Component\Paging\Factory\Factory as PagingFactory;
use GI\Component\Switcher\Factory\Factory as SwitcherFactory;

use GI\Component\Authentication\Login\Login;
use GI\Component\Authentication\Login\Dialog\Dialog;
use GI\Component\Authentication\Logout\Logout;
use GI\Component\Authentication\Authentication;

use GI\Component\Locales\Locales;


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
 * Class Factory
 * @package GI\Component\Factory
 *
 * @method LoginInterface createLogin()
 * @method DialogInterface createLoginDialog()
 * @method LogoutInterface createLogout()
 * @method AuthenticationInterface createAuthentication()
 * @method LocalesInterface createLocales()
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * @var CaptchaFactoryInterface
     */
    private $captchaFactory;

    /**
     * @var ErrorFactoryInterface
     */
    private $errorFactory;

    /**
     * @var PagingFactoryInterface
     */
    private $pagingFactory;

    /**
     * @var SwitcherFactoryInterface
     */
    private $switcherFactory;


    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->set(Login::class)
            ->setNamed('LoginDialog', Dialog::class)
            ->set(Logout::class)
            ->set(Authentication::class, null, false)

            ->set(Locales::class);
    }

    /**
     * @return CaptchaFactoryInterface
     */
    public function getCaptchaFactory()
    {
        if (!($this->captchaFactory instanceof CaptchaFactoryInterface)) {
            $this->captchaFactory = new CaptchaFactory();
        }

        return $this->captchaFactory;
    }

    /**
     * @return ErrorFactoryInterface
     */
    public function getErrorFactory()
    {
        if (!($this->errorFactory instanceof ErrorFactoryInterface)) {
            $this->errorFactory = new ErrorFactory();
        }

        return $this->errorFactory;
    }

    /**
     * @return PagingFactoryInterface
     */
    public function getPagingFactory()
    {
        if (!($this->pagingFactory instanceof PagingFactoryInterface)) {
            $this->pagingFactory = new PagingFactory();
        }

        return $this->pagingFactory;
    }

    /**
     * @return SwitcherFactoryInterface
     */
    public function getSwitcherFactory()
    {
        if (!($this->switcherFactory instanceof SwitcherFactoryInterface)) {
            $this->switcherFactory = new SwitcherFactory();
        }

        return $this->switcherFactory;
    }
}