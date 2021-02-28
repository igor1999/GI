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
namespace GI\ServiceLocator\Traits;

use GI\SessionExchange\SessionExchange;

use GI\SessionExchange\SessionExchangeInterface;

trait SessionExchangeTrait
{
    /**
     * @var SessionExchangeInterface
     */
    private $sessionExchange;


    /**
     * @return SessionExchangeInterface
     */
    protected function getSessionExchange()
    {
        if (!($this->sessionExchange instanceof SessionExchangeInterface)) {
            $this->sessionExchange = new SessionExchange();
        }

        return $this->sessionExchange;
    }

    /**
     * @return string
     */
    public function getSessionID()
    {
        return $this->getSessionExchange()->getSessionID();
    }

    /**
     * @param string[] $classes
     * @return static
     * @throws \Exception
     */
    public function setSessionExchangeClasses(array $classes)
    {
        $this->validateClosing();

        $this->getSessionExchange()->setByNames($classes);

        return $this;
    }

    /**
     * @param array|null $session
     * @return static
     * @throws \Exception
     */
    public function loadSession(array $session = null)
    {
        $this->validateClosing();

        $this->getSessionExchange()->load($session);

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function saveSession()
    {
        return $this->getSessionExchange()->save();
    }
}