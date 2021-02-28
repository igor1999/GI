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
namespace GI\RDB\Platform\Factory;

use GI\RDB\Platform\MYSQL\MYSQL;
use GI\RDB\Platform\SQLServer\SQLServer;
use GI\RDB\Platform\DB2\DB2;
use GI\RDB\Platform\Oracle\Oracle;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\RDB\Platform\Exception\ExceptionAwareTrait;

use GI\RDB\Platform\PlatformInterface;

use GI\RDB\Platform\MYSQL\MYSQLInterface;
use GI\RDB\Platform\SQLServer\SQLServerInterface;
use GI\RDB\Platform\DB2\DB2Interface;
use GI\RDB\Platform\Oracle\OracleInterface;

class Factory implements FactoryInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    /**
     * @var MYSQLInterface
     */
    private $mysql;

    /**
     * @var SQLServerInterface
     */
    private $sqlServer;

    /**
     * @var DB2Interface
     */
    private $db2;

    /**
     * @var OracleInterface
     */
    private $oracle;


    /**
     * Factory constructor.
     */
    public function __construct()
    {
        $this->mysql     = new MYSQL();
        $this->sqlServer = new SQLServer();
        $this->db2       = new DB2();
        $this->oracle    = new Oracle();
    }

    /**
     * @return MYSQLInterface
     */
    protected function getMysql()
    {
        return $this->mysql;
    }

    /**
     * @return SQLServerInterface
     */
    protected function getSqlServer()
    {
        return $this->sqlServer;
    }

    /**
     * @return DB2Interface
     */
    protected function getDb2()
    {
        return $this->db2;
    }

    /**
     * @return OracleInterface
     */
    protected function getOracle()
    {
        return $this->oracle;
    }

    /**
     * @param \PDO $pdo
     * @return PlatformInterface
     * @throws \Exception
     */
    public function get(\PDO $pdo)
   {
        switch ($pdo->getAttribute(\PDO::ATTR_DRIVER_NAME)) {
            case self::MYSQL_DRIVER:
                $platform = $this->getMysql();
                break;
            case self::SQL_SERVER_DRIVER:
            case self::DB_LIB_DRIVER:
                $platform = $this->getSqlServer();
                break;
            case self::DB2_DRIVER:
                $platform = $this->getDb2();
                break;
            case self::ORACLE_DRIVER:
                $platform = $this->getOracle();
                break;
            default:
                $platform = null;
                $this->throwPlatformException($pdo);
        }

        return $platform;
    }
}