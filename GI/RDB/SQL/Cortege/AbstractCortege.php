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
namespace GI\RDB\SQL\Cortege;

use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\Alterable;

use GI\RDB\Meta\Table\TableInterface;

abstract class AbstractCortege extends Alterable implements CortegeInterface
{
    const SEPARATOR = ', ';


    /**
     * @var TableInterface|null
     */
    private $table;

    /**
     * @var TableInterface|null
     */
    private $joinTable;


    /**
     * AbstractCortege constructor.
     * @param array $items
     * @param TableInterface|null $table
     * @param TableInterface|null $joinTable
     * @throws \Exception
     */
    public function __construct(array $items, TableInterface $table = null, TableInterface $joinTable = null)
    {
        parent::__construct($items);

        $this->table     = $table;
        $this->joinTable = $joinTable;
    }

    /**
     * @return bool
     */
    public function hasTable()
    {
        return $this->table instanceof TableInterface;
    }

    /**
     * @return TableInterface
     * @throws \Exception
     */
    public function getTable()
    {
        if (!$this->hasTable()) {
            $this->getGiServiceLocator()->throwNotSetException('Basic table');
        }

        return $this->table;
    }

    /**
     * @return bool
     */
    public function hasJoinTable()
    {
        return $this->joinTable instanceof TableInterface;
    }

    /**
     * @return TableInterface
     * @throws \Exception
     */
    public function getJoinTable()
    {
        if (!$this->hasJoinTable()) {
            $this->getGiServiceLocator()->throwNotSetException('Join table');
        }

        return $this->joinTable;
    }

    /**
     * @param TableInterface|null $joinTable
     * @return static
     */
    protected function setJoinTable(TableInterface $joinTable = null)
    {
        $this->joinTable = $joinTable;

        return $this;
    }

    /**
     * @param bool $forKeys
     * @return string[]
     * @throws \Exception
     */
    protected function createFieldList($forKeys = true)
    {
        $f = function($item, $key) use ($forKeys)
        {
            if ($forKeys && $this->hasTable()) {
                $field = $this->getTable()->getColumnList()->get($key)->getFullQualifiedName();
            } elseif (!$forKeys && $this->hasJoinTable()) {
                $field = $this->getJoinTable()->getColumnList()->get($item)->getFullQualifiedName();
            } else {
                $field = $forKeys ? $key : $item;
            }

            return $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()->createFieldExpression($field)->toString();
        };

        return $this->getPairsWithClosure($f);
    }

    /**
     * @return string[]
     */
    protected function createParamList()
    {
        $f = function($item, $key)
        {
            unset($item);

            return $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()->createParamExpression($key)->toString();
        };

        return $this->getPairsWithClosure($f);
    }

    /**
     * @return string[]
     * @throws \Exception
     */
    protected function createAssignList()
    {
        $f = function($field, $param)
        {
            return $field . self::DEFAULT_PAIR_GLUE . $param;
        };

        return array_map($f, $this->createFieldList(), $this->createParamList());
    }

    /**
     * @return string[]
     * @throws \Exception
     */
    protected function createJoinList()
    {
        $f = function($field1, $field2)
        {
            return $field1 . self::DEFAULT_PAIR_GLUE . $field2;
        };

        return array_map($f, $this->createFieldList(), $this->createFieldList(false));
    }
}