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
namespace GI\Component\Authentication;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Component\Authentication\Login\LoginInterface;
use GI\Component\Authentication\Logout\LogoutInterface;
use GI\Identity\IdentityInterface;

class Authentication implements AuthenticationInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var LoginInterface
     */
    private $login;

    /**
     * @var LogoutInterface
     */
    private $logout;

    /**
     * @var IdentityInterface
     */
    private $identity;


    /**
     * Authentication constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createIdentity();

        $this->login  = $this->giGetComponentFactory()->createLogin();
        $this->logout = $this->giGetComponentFactory()->createLogout();
    }

    /**
     * @return IdentityInterface
     */
    protected function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createIdentity()
    {
        try {
            $this->identity = $this->giGetDi(IdentityInterface::class);
        } catch (\Exception $e) {
            $this->giThrowDependencyException('Identity');
        }

        return $this;
    }

    /**
     * @return LoginInterface
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return LogoutInterface
     */
    public function getLogout()
    {
        return $this->logout;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getIdentity()->isAuthenticated() ? $this->getLogout()->toString() : $this->getLogin()->toString();
    }
}