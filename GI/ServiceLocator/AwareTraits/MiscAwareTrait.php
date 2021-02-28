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
namespace GI\ServiceLocator\AwareTraits;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\Selection\Factory\FactoryInterface as ClientSelectionFactoryInterface;
use GI\Calendar\Factory\FactoryInterface as CalendarFactoryInterface;
use GI\Email\EmailInterface;
use GI\Logger\LoggerInterface;
use GI\Storage\Factory\FactoryInterface as StorageFactoryInterface;
use GI\SocketDemon\Factory\FactoryInterface as SocketDemonFactoryInterface;

trait MiscAwareTrait
{
    /**
     * @return ClientSelectionFactoryInterface
     */
    protected function giGetClientSelectionFactory()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getClientSelectionFactory(static::class);
    }

    /**
     * @return EmailInterface
     */
    protected function giCreateEmail()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->createEmail(static::class);
    }

    /**
     * @return CalendarFactoryInterface
     */
    protected function giGetCalendarFactory()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getCalendarFactory(static::class);
    }

    /**
     * @return LoggerInterface
     */
    protected function giCreateLogger()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->createLogger(static::class);
    }

    /**
     * @return StorageFactoryInterface
     */
    protected function giGetStorageFactory()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getStorageFactory(static::class);
    }

    /**
     * @return SocketDemonFactoryInterface
     */
    protected function giGetSocketDemonFactory()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getSocketDemonFactory(static::class);
    }
}