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

use GI\RDB\Platform\PlatformInterface;
use GI\RDB\SQL\Factory\FactoryInterface as SQLFactoryInterface;

trait RDBAwareTrait
{
    /**
     * @param \PDO $pdo
     * @return PlatformInterface
     * @throws \Exception
     */
    protected function giGetRDBPlatform(\PDO $pdo)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getRdbDI()->getPlatform($pdo, static::class);
    }

    /**
     * @return SQLFactoryInterface
     * @throws \Exception
     */
    protected function giGetSqlFactory()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getRdbDI()->getSqlFactory(static::class);
    }
}