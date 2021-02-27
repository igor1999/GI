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
namespace GI\RDB\Driver\Behaviour\Execution;

use GI\RDB\Driver\Behaviour\AbstractBehaviour;

use GI\RDB\Driver\Exception\Fetch\ExceptionAwareTrait as FetchExceptionAwareTrait;
use GI\RDB\Driver\Exception\Statement\ExceptionAwareTrait as StatementExceptionAwareTrait;

use GI\RDB\Platform\PlatformInterface;

class Execution extends AbstractBehaviour implements ExecutionInterface
{
    use FetchExceptionAwareTrait, StatementExceptionAwareTrait;


    /**
     * @var PlatformInterface
     */
    private $platform;


    /**
     * Execution constructor.
     * @param \PDO $pdo
     * @throws \Exception
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);

        $this->platform = $this->giGetRDBPlatform($this->getPdo());
    }

    /**
     * @return PlatformInterface
     */
    protected function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     * @throws \Exception
     */
    protected function createAndExecuteStatement(string $sql, array $params)
    {
        $f = function($field)
        {
            return $this->getPlatform()->quoteEntity($field);
        };
        $sql = $this->giGetSqlFactory()->createFieldParser()->parse($sql, $f);

        $statement = $this->getPdo()->prepare($sql);
        $statement->execute($params);

        $this->throwPDOStatementExceptionIfExists($statement);

        return $statement;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return int
     * @throws \Exception
     */
    public function execute(string $sql, array $params = [])
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        $result = $statement->rowCount();
        $statement->closeCursor();

        return $result;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function fetch(string $sql, array $params = [])
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        $statement->closeCursor();

        if (!is_array($result)) {
            $this->throwFetchException($sql);
        }

        return $result;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array[]
     * @throws \Exception
     */
    public function fetchAll(string $sql, array $params = [])
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $statement->closeCursor();

        return $result;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param int $index
     * @return array
     * @throws \Exception
     */
    public function fetchColumn(string $sql, array $params = [], int $index = 0)
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        $result = $statement->fetchAll(\PDO::FETCH_COLUMN, $index);
        $statement->closeCursor();

        return $result;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function fetchPair(string $sql, array $params = [])
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        $result = $statement->fetchAll(\PDO::FETCH_KEY_PAIR);
        $statement->closeCursor();

        return $result;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param int $index
     * @return string
     * @throws \Exception
     */
    public function fetchValue(string $sql, array $params = [], int $index = 0)
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        $result = $statement->fetchColumn($index);
        $statement->closeCursor();

        return $result;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function fetchMeta(string $sql, array $params = [])
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        $meta = [];
        for ($index = 0; $index <= $statement->columnCount() - 1; $index ++) {
            $meta[] = $statement->getColumnMeta($index);
        }

        return $meta;
    }

    /**
     * @param \Closure $callback
     * @param string $sql
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function fetchExtra(\Closure $callback, string $sql, array $params = [])
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        call_user_func($callback, $statement);

        $result = $statement->fetch();
        $statement->closeCursor();

        return $result;
    }

    /**
     * @param \Closure $callback
     * @param string $sql
     * @param array $params
     * @return mixed[]
     * @throws \Exception
     */
    public function fetchAllExtra(\Closure $callback, string $sql, array $params = [])
    {
        $statement = $this->createAndExecuteStatement($sql, $params);

        call_user_func($callback, $statement);

        $result = $statement->fetchAll();
        $statement->closeCursor();

        return $result;
    }

    /**
     * @param string|null $name
     * @return int
     */
    public function getLastInsertId(string $name = null)
    {
        return (int)$this->getPdo()->lastInsertId($name);
    }
}