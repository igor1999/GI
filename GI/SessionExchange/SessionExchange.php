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
namespace GI\SessionExchange;

use GI\SessionExchange\ClassMeta\ClassMeta;

use GI\Meta\ClassMeta\Collection\Alterable;
use GI\CLI\Job\AbstractJob;
use GI\Security\Captcha\Base\AbstractCaptcha;
use GI\Security\CSRF\CSRF;

use GI\SessionExchange\ClassMeta\ClassMetaInterface;

class SessionExchange extends Alterable implements SessionExchangeInterface
{

    /**
     * @var bool
     */
    private $realSession = true;

    /**
     * @var string
     */
    private $sessionID = '';


    /**
     * SessionExchange constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->sessionID = session_id();

        if (empty($this->sessionID)) {
            session_start();
            $this->sessionID = session_id();
        }

        $this->setByNames($this->getFrameworkClasses());
    }

    /**
     * @return array
     */
    protected function getFrameworkClasses()
    {
        return [
            AbstractJob::class,
            AbstractCaptcha::class,
            CSRF::class
        ];
    }

    /**
     * @return string
     */
    public function getSessionID()
    {
        return $this->sessionID;
    }

    /**
     * @return ClassMetaInterface[]
     */
    public function getItems()
    {
        /** @var ClassMetaInterface[] $items */
        $items = parent::getItems();

        return $items;
    }

    /**
     * @param string $class
     * @return ClassMeta
     * @throws \Exception
     */
    protected function createClassMeta($class)
    {
        return new ClassMeta($class);
    }

    /**
     * @param string[] $classes
     * @return static
     * @throws \Exception
     */
    public function setByNames(array $classes)
    {
        foreach ($classes as $class) {
            $this->setByName($class);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isRealSession()
    {
        return $this->realSession;
    }

    /**
     * @param bool $realSession
     * @return static
     */
    protected function setIsRealSession($realSession)
    {
        $this->realSession = $realSession;

        return $this;
    }

    /**
     * @param array|null $session
     * @return static
     * @throws \Exception
     */
    public function load(array $session = null)
    {
        $this->setIsRealSession(!is_array($session));

        if ($this->realSession) {
            $session = &$_SESSION;
        }

        foreach ($this->getItems() as $class => $item) {
            if (isset($session[self::GLOBAL_CACHE_KEY][$class])) {
                $data = $session[self::GLOBAL_CACHE_KEY][$class];
            } else {
                $data = '';
            }

            $item->load($data);
        }

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function save()
    {
        $session = [];
        if ($this->realSession) {
            $session = &$_SESSION;
        }

        foreach ($this->getItems() as $class => $item) {
            $session[self::GLOBAL_CACHE_KEY][$class] = $item->save();
        }

        return $session;
    }
}