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
namespace GI\Identity\ArrayIdentity;

use GI\Identity\AbstractIdentity as Base;

use GI\Identity\Exception\ExceptionAwareTrait;

use GI\Storage\Tree\TreeInterface;

abstract class AbstractIdentity extends Base implements IdentityInterface
{
    use ExceptionAwareTrait;


    /**
     * @var string
     */
    private $cookieName = '';

    /**
     * @var int
     */
    private $expires = 60 * 60 * 24 * 365;


    /**
     * @return TreeInterface
     */
    abstract protected function getSessionCache();

    /**
     * @param string $login
     * @param string $password
     * @return array
     */
    abstract protected function createByCredentials(string $login, string $password);

    /**
     * @param int $id
     * @return array
     */
    abstract protected function createByUserID(int $id);

    /**
     * @param mixed $data
     * @param bool $saveInCookie
     * @return static
     * @throws \Exception
     */
    protected function set($data, bool $saveInCookie = false)
    {
        $this->setArray($data, $saveInCookie);

        return $this;
    }

    /**
     * @param array $data
     * @param bool $saveInCookie
     * @return static
     * @throws \Exception
     */
    protected function setArray(array $data, bool $saveInCookie = false)
    {
        $this->getSessionCache()->hydrate($data);

        if ($this->isAuthenticated() && $saveInCookie && $this->hasCookie()) {
            setcookie($this->cookieName, $this->getID(), time() + $this->expires);
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function cleanCache()
    {
        $this->getSessionCache()->clean();

        return $this;
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return !$this->getSessionCache()->isEmpty();
    }

    /**
     * @param string|int|array $key
     * @return bool
     * @throws \Exception
     */
    public function has($key)
    {
        return $this->getSessionCache()->has($key);
    }

    /**
     * @param string|int|array $key
     * @return mixed
     * @throws \Exception
     */
    public function get($key)
    {
        try {
            $result = $this->getSessionCache()->get($key);
        } catch (\Exception $exception) {
            $result = null;
            if (is_array($key)) {
                $key = implode(', ', $key);
            }

            $this->throwIdentityKeyException($key);
        }

        return $result;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return bool|mixed
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $has = $this->giGetPSRFormatParser()->parseWithPrefixHas($method);
        } catch (\Exception $exception) {
            try {
                $get = $this->giGetPSRFormatParser()->parseWithPrefixGet($method);
            } catch (\Exception $exception) {
                $this->giThrowMagicMethodException($method);
            }
        }

        $result = null;

        if (!empty($has)) {
            $result = $this->has($has);
        } elseif (!empty($get)) {
            $result = $this->get($get);
        }

        return $result;
    }
}