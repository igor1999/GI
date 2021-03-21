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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Identity\Context\ContextInterface;

abstract class AbstractIdentity implements IdentityInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $cookieName = '';

    /**
     * @var int
     */
    private $expires = 60 * 60 * 24 * 365;


    /**
     * AbstractIdentity constructor.
     */
    public function __construct()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);
            $this->cookieName = $context->getCookieName();
            $this->expires    = $context->getExpires();
        } catch (\Exception $e) {}
    }

    /**
     * @return string
     */
    protected function getCookieName()
    {
        return $this->cookieName;
    }

    /**
     * @return bool
     */
    public function hasCookie()
    {
        return !empty($this->cookieName);
    }

    /**
     * @return int
     */
    protected function getExpires()
    {
        return $this->expires;
    }

    /**
     * @return mixed
     */
    abstract protected function getSessionCache();

    /**
     * @param string $login
     * @param string $password
     * @param bool $saveInCookie
     * @return bool
     * @throws \Exception
     */
    public function authenticate(string $login, string $password, bool $saveInCookie = false)
    {
        $this->set($this->createByCredentials($login, $password), $saveInCookie);

        return $this->isAuthenticated();
    }

    /**
     * @param string $login
     * @param string $password
     * @return mixed
     */
    abstract protected function createByCredentials(string $login, string $password);

    /**
     * @return bool
     */
    public function authenticateByCookie()
    {
        if (!$this->isAuthenticated() && $this->hasCookie()) {
            try {
                $id = $this->giGetRequest()->getCookie()->get($this->cookieName);
                $this->set($this->createByUserID($id));
            } catch (\Exception $e) {}
        }

        return $this->isAuthenticated();
    }

    /**
     * @param int $id
     * @return mixed
     */
    abstract protected function createByUserID(int $id);

    /**
     * @param mixed $data
     * @param bool $saveInCookie
     * @return static
     * @throws \Exception
     */
    abstract protected function set($data, bool $saveInCookie = false);

    /**
     * @return static
     * @throws \Exception
     */
    public function clean()
    {
        $this->cleanCache();

        if ($this->hasCookie() && $this->giGetRequest()->getCookie()->has($this->cookieName)) {
            setcookie($this->cookieName);
        }

        return $this;
    }

    /**
     * @return static
     */
    abstract protected function cleanCache();
}