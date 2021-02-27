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
namespace GI\RDB\Driver;

use GI\RDB\Driver\Behaviour\Transaction\Transaction;
use GI\RDB\Driver\Behaviour\Execution\Execution;
use GI\RDB\Meta\Table\TableList;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\RDB\Driver\Exception\PDO\ExceptionAwareTrait;

use GI\RDB\Driver\Context\ContextInterface;
use GI\RDB\Platform\PlatformInterface;
use GI\RDB\Driver\Behaviour\Transaction\TransactionInterface;
use GI\RDB\Driver\Behaviour\Execution\ExecutionInterface;
use GI\RDB\Meta\Table\TableListInterface;

/**
 * Class AbstractDriver
 * @package GI\RDB\Driver
 *
 * @method DriverInterface startTransaction()
 * @method DriverInterface commit()
 * @method DriverInterface rollBack()
 *
 * @method int execute(string $sql, array $params = [])
 * @method array fetch(string $sql, array $params = [])
 * @method array fetchAll(string $sql, array $params = [])
 * @method array fetchColumn(string $sql, array $params = [], $index = 0)
 * @method array fetchPair(string $sql, array $params = [])
 * @method string fetchValue(string$sql, array $params = [], $index = 0)
 * @method array fetchMeta(string $sql, array $params = [])
 * @method fetchExtra(\Closure $callback, string $sql, array $params = [])
 * @method array fetchAllExtra(\Closure $callback, string $sql, array $params = [])
 * @method int getLastInsertId(string $name = null)
 */
abstract class AbstractDriver implements DriverInterface
{
    use ServiceLocatorAwareTrait, ExceptionAwareTrait;


    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var PlatformInterface
     */
    private $platform;

    /**
     * @var TransactionInterface
     */
    private $transactionHandler;

    /**
     * @var ExecutionInterface
     */
    private $executionHandler;

    /**
     * @var TableListInterface
     */
    private $tableList;


    /**
     * AbstractDriver constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createContext();

        $this->pdo = new \PDO(
            $this->getContext()->getDSN(),
            $this->getContext()->getUser(),
            $this->getContext()->getPassword(),
            $this->getContext()->getOptions()
        );

        $this->throwPDOExceptionIfExists($this->pdo);

        $this->platform = $this->giGetRDBPlatform($this->pdo);

        $this->transactionHandler = $this->giGetDi(
            TransactionInterface::class, Transaction::class, [$this->pdo]
        );

        $this->executionHandler = $this->giGetDi(
            ExecutionInterface::class, Execution::class, [$this->pdo]
        );

        $this->tableList = $this->giGetDi(TableListInterface::class, new TableList($this), [$this]);
    }

    /**
     * @return ContextInterface
     */
    abstract protected function getContext();

    /**
     * @return static
     */
    abstract protected function createContext();

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->getContext()->getDatabase();
    }

    /**
     * @return \PDO
     */
    protected function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @return PlatformInterface
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @return TransactionInterface
     */
    protected function getTransactionHandler()
    {
        return $this->transactionHandler;
    }

    /**
     * @return ExecutionInterface
     */
    protected function getExecutionHandler()
    {
        return $this->executionHandler;
    }

    /**
     * @return TableListInterface
     */
    public function getTableList()
    {
        return $this->tableList;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return static|mixed
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        if (method_exists($this->getTransactionHandler(), $method)) {
            $result = call_user_func_array([$this->getTransactionHandler(), $method], $arguments);
            if ($result === $this->getTransactionHandler()) {
                $result = $this;
            }
        } elseif (method_exists($this->getExecutionHandler(), $method)) {
            $result = call_user_func_array([$this->getExecutionHandler(), $method], $arguments);
            if ($result === $this->getExecutionHandler()) {
                $result = $this;
            }
        } else {
            try {
                $table = $this->giGetPSRFormatParser()->parseWithPrefixGet($method);
            } catch (\Exception $e) {
                $table = null;
                $this->giThrowMagicMethodException($method);
            }

            $table  = $this->giGetCamelCaseConverter()->convertToUnderlineLowerCase($table);
            $result = $this->getTableList()->get($table);
        }

        return $result;
    }

    /**
     * @param string $table
     * @return array
     */
    public function fetchColumnList(string $table)
    {
        $sql = $this->getPlatform()->getColumnListQuery();

        $params = [
            'database' => $this->getDatabase(),
            'table'    => $table
        ];

        return $this->fetchAll($sql, $params);
    }

    /**
     * @return array
     */
    public function fetchTableList()
    {
        $sql = $this->getPlatform()->getTableListQuery();

        $params = [
            'database' => $this->getDatabase(),
        ];

        return $this->fetchColumn($sql, $params);
    }

    /**
     * @param string $table
     * @return array
     */
    public function fetchTableDetail(string $table)
    {
        $sql = $this->getPlatform()->getTableDetailQuery();

        $params = [
            'database' => $this->getDatabase(),
            'table'    => $table
        ];

        return $this->fetchAll($sql, $params);
    }

    /**
     * @param string $table
     * @return string
     */
    public function fetchTableIdentity(string $table)
    {
        $sql = $this->getPlatform()->getTableIdentityQuery();

        $params = [
            'database' => $this->getDatabase(),
            'table'    => $table
        ];

        return $this->fetchValue($sql, $params);
    }

    /**
     * @param string $table
     * @return int
     * @throws \Exception
     */
    public function getTableLastInsertId(string $table)
    {
        $column = $this->getTableList()->get($table)->getColumnList()->getIdentity()->getName();

        return $this->getLastInsertId($this->getContext()->getIdentitySequence($table, $column));
    }
}