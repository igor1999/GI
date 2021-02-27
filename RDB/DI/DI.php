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

use GI\RDB\Platform\Factory\Factory as PlatformFactory;
use GI\RDB\SQL\Factory\Factory as SQLFactory;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Platform\Factory\FactoryInterface as PlatformFactoryInterface;
use GI\RDB\Platform\PlatformInterface;
use GI\RDB\SQL\Factory\FactoryInterface as SQLFactoryInterface;

class DI implements DIInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var PlatformFactoryInterface
     */
    private $platformFactory;

    /**
     * @var SQLFactoryInterface
     */
    private $sqlFactory;


    /**
     * @param \PDO $pdo
     * @param string|null $caller
     * @return PlatformInterface
     * @throws \Exception
     */
    public function getPlatform(\PDO $pdo, string $caller = null)
    {
        try {
            $factory = $this->giGetServiceLocator()->getDi()->find(
                PlatformFactoryInterface::class, $caller
            );
        } catch (\Exception $e) {
            if (!($this->platformFactory instanceof PlatformFactoryInterface)) {
                $this->platformFactory = new PlatformFactory();
            }

            $factory = $this->platformFactory;
        }

        return $factory->get($pdo);
    }

    /**
     * @param string|null $caller
     * @return SQLFactoryInterface
     * @throws \Exception
     */
    public function getSqlFactory(string $caller = null)
    {
        try {
            $result = $this->giGetServiceLocator()->getDi()->find(SQLFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->sqlFactory instanceof SQLFactoryInterface)) {
                $this->sqlFactory = new SQLFactory();
            }

            $result = $this->sqlFactory;
        }

        return $result;
    }
}