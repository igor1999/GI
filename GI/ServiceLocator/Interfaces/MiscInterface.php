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
namespace GI\ServiceLocator\Interfaces;

use GI\ClientContents\Selection\Factory\FactoryInterface as ClientSelectionFactoryInterface;
use GI\Calendar\Factory\FactoryInterface as CalendarFactoryInterface;
use GI\Email\EmailInterface;
use GI\Logger\LoggerInterface;
use GI\Storage\Factory\FactoryInterface as StorageFactoryInterface;
use GI\SocketDemon\Factory\FactoryInterface as SocketDemonFactoryInterface;

interface MiscInterface
{
    /**
     * @param string|null $caller
     * @return ClientSelectionFactoryInterface
     */
    public function getClientSelectionFactory(string $caller = null);

    /**
     * @param string|null $caller
     * @return EmailInterface
     */
    public function createEmail(string $caller = null);

    /**
     * @param string|null $caller
     * @return CalendarFactoryInterface
     */
    public function getCalendarFactory(string $caller = null);

    /**
     * @param string|null $caller
     * @return LoggerInterface
     */
    public function createLogger(string $caller = null);

    /**
     * @param string|null $caller
     * @return StorageFactoryInterface
     */
    public function getStorageFactory(string $caller = null);

    /**
     * @param string|null $caller
     * @return SocketDemonFactoryInterface
     */
    public function getSocketDemonFactory(string $caller = null);
}