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

use GI\ClientContents\Selection\Factory\Factory as ClientSelectionFactory;
use GI\Calendar\Factory\Factory as CalendarFactory;
use GI\Email\Email;
use GI\Logger\Logger;
use GI\Storage\Factory\Factory as StorageFactory;
use GI\SocketDemon\Factory\Factory as SocketDemonFactory;

use GI\ServiceLocator\ServiceLocatorInterface;
use GI\ClientContents\Selection\Factory\FactoryInterface as ClientSelectionFactoryInterface;
use GI\Calendar\Factory\FactoryInterface as CalendarFactoryInterface;
use GI\Email\EmailInterface;
use GI\Logger\LoggerInterface;
use GI\Storage\Factory\FactoryInterface as StorageFactoryInterface;
use GI\SocketDemon\Factory\FactoryInterface as SocketDemonFactoryInterface;

trait MiscTrait
{
    /**
     * @var ClientSelectionFactoryInterface
     */
    private $clientSelectionFactory;

    /**
     * @var CalendarFactoryInterface
     */
    private $calendarFactory;

    /**
     * @var StorageFactoryInterface
     */
    private $storageFactory;

    /**
     * @var SocketDemonFactoryInterface
     */
    private $socketDemonFactory;


    /**
     * @param string|null $caller
     * @return ClientSelectionFactoryInterface
     */
    public function getClientSelectionFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(ClientSelectionFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->clientSelectionFactory instanceof ClientSelectionFactoryInterface)) {
                $this->clientSelectionFactory = new ClientSelectionFactory();
            }

            $result = $this->clientSelectionFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return EmailInterface
     */
    public function createEmail(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(EmailInterface::class, $caller);
        } catch (\Exception $e) {
            $result = new Email();
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return CalendarFactoryInterface
     */
    public function getCalendarFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(CalendarFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->calendarFactory instanceof CalendarFactoryInterface)) {
                $this->calendarFactory = new CalendarFactory();
            }

            $result = $this->calendarFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return LoggerInterface
     */
    public function createLogger(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(LoggerInterface::class, $caller);
        } catch (\Exception $e) {
            $result = new Logger();
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return StorageFactoryInterface
     */
    public function getStorageFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(StorageFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->storageFactory instanceof StorageFactoryInterface)) {
                $this->storageFactory = new StorageFactory();
            }

            $result = $this->storageFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return SocketDemonFactoryInterface
     */
    public function getSocketDemonFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(SocketDemonFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->socketDemonFactory instanceof SocketDemonFactoryInterface)) {
                $this->socketDemonFactory = new SocketDemonFactory();
            }

            $result = $this->socketDemonFactory;
        }

        return $result;
    }
}