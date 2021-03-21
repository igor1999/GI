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
namespace GI\Identity;

use GI\SessionExchange\BaseInterface\Aware\SessionExchangeAwareInterface;

interface IdentityInterface extends SessionExchangeAwareInterface
{
    /**
     * @return bool
     */
    public function hasCookie();

    /**
     * @param string $login
     * @param string $password
     * @param bool $saveInCookie
     * @return bool
     * @throws \Exception
     */
    public function authenticate(string $login, string $password, bool $saveInCookie = false);

    /**
     * @return bool
     */
    public function authenticateByCookie();

    /**
     * @return int
     */
    public function getID();

    /**
     * @return string
     */
    public function getLogin();

    /**
     * @return string
     */
    public function getRole();

    /**
     * @return string
     */
    public function getSignature();

    /**
     * @return static
     * @throws \Exception
     */
    public function clean();

    /**
     * @return bool
     */
    public function isAuthenticated();
}