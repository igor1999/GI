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
namespace GI\RDB\DI;

use GI\RDB\Platform\PlatformInterface;
use GI\RDB\SQL\Factory\FactoryInterface as SQLFactoryInterface;

interface DIInterface 
{
    /**
     * @param \PDO $pdo
     * @param string|null $caller
     * @return PlatformInterface
     * @throws \Exception
     */
    public function getPlatform(\PDO $pdo, string $caller = null);

    /**
     * @param string|null $caller
     * @return SQLFactoryInterface
     * @throws \Exception
     */
    public function getSqlFactory(string $caller = null);
}