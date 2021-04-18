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
namespace GI\RDB\Meta\Table\QueryBuilder;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;
use GI\RDB\Meta\Table\TableInterface;

class QueryBuilder implements QueryBuilderInterface
{
    use ServiceLocatorAwareTrait;


    const INSERT_TEMPLATE     = 'INSERT INTO %table%(%field-list%) VALUES(%param-list%)';

    const DELETE_TEMPLATE     = 'DELETE FROM %table% WHERE %predicate-list%';

    const UPDATE_TEMPLATE     = 'UPDATE %table% SET %assign-list% WHERE %predicate-list%';

    const SELECT_TEMPLATE     = 'SELECT * FROM %table% WHERE %predicate-list% %order%';

    const SELECT_ALL_TEMPLATE = 'SELECT * FROM %table% %order%';


    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @var SQLBuilderInterface
     */
    private $builder;


    /**
     * QueryBuilder constructor.
     * @param TableInterface $table
     * @throws \Exception
     */
    public function __construct(TableInterface $table)
    {
        $this->table = $table;

        $this->builder = $this->giGetSqlFactory()->createSQLBuilder();
    }

    /**
     * @return TableInterface
     */
    protected function getTable()
    {
        return $this->table;
    }

    /**
     * @return SQLBuilderInterface
     */
    protected function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @param array $contents
     * @param SQLBuilderInterface|null $builder
     * @return string
     * @throws \Exception
     */
    public function insert(array $contents, SQLBuilderInterface $builder = null)
    {
        if (empty($contents)) {
            $this->giThrowIsEmptyException('Insert contents');
        }

        if (!($builder instanceof SQLBuilderInterface)) {
            $builder = $this->getBuilder()->setTemplate(static::INSERT_TEMPLATE);
        }

        $table = $this->giGetSqlFactory()->createFieldExpression($this->getTable()->getFullName());
        $builder->setParam('table', $table->toString());

        $fieldList = ($builder instanceof SQLBuilderInterface)
            ? $this->giGetSqlFactory()->createFieldCortege($contents, $this->getTable())
            : $this->giGetSqlFactory()->createFieldCortege($contents);
        $builder->setParam('field-list', $fieldList->toString());

        $paramList = $this->giGetSqlFactory()->createParamCortege($contents);
        $builder->setParam('param-list', $paramList->toString());

        return $builder->toString();
    }

    /**
     * @param array $contents
     * @param SQLBuilderInterface|null $builder
     * @return string
     * @throws \Exception
     */
    public function delete(array $contents, SQLBuilderInterface $builder = null)
    {
        if (empty($contents)) {
            $this->giThrowIsEmptyException('Delete contents');
        }

        if (!($builder instanceof SQLBuilderInterface)) {
            $builder = $this->getBuilder()->setTemplate(static::DELETE_TEMPLATE);
        }

        $table = $this->giGetSqlFactory()->createFieldExpression($this->getTable()->getFullName());
        $builder->setParam('table', $table->toString());

        $predicateList = ($builder instanceof SQLBuilderInterface)
            ? $this->giGetSqlFactory()->createAndAssignPredicates($contents, $this->getTable())
            : $this->giGetSqlFactory()->createAndAssignPredicates($contents);
        $builder->setParam('predicate-list', $predicateList->toString());

        return $builder->toString();
    }

    /**
     * @param array $values
     * @param array $conditions
     * @param SQLBuilderInterface|null $builder
     * @return string
     * @throws \Exception
     */
    public function update(array $values, array $conditions, SQLBuilderInterface $builder = null)
    {
        if (empty($values)) {
            $this->giThrowIsEmptyException('Assigned values');
        }

        if (empty($conditions)) {
            $this->giThrowIsEmptyException('Search conditions');
        }

        if (!($builder instanceof SQLBuilderInterface)) {
            $builder = $this->getBuilder()->setTemplate(static::UPDATE_TEMPLATE);
        }

        $table = $this->giGetSqlFactory()->createFieldExpression($this->getTable()->getFullName());
        $builder->setParam('table', $table->toString());

        $assignList = ($builder instanceof SQLBuilderInterface)
            ? $this->giGetSqlFactory()->createAssignCortege($values, $this->getTable())
            : $this->giGetSqlFactory()->createAssignCortege($values);
        $builder->setParam('assign-list', $assignList->toString());

        $predicateList = ($builder instanceof SQLBuilderInterface)
            ? $this->giGetSqlFactory()->createAndAssignPredicates($conditions, $this->getTable())
            : $this->giGetSqlFactory()->createAndAssignPredicates($conditions);
        $builder->setParam('predicate-list', $predicateList->toString());

        return $builder->toString();
    }

    /**
     * @param array $contents
     * @param array $order
     * @param SQLBuilderInterface|null $builder
     * @return string
     * @throws \Exception
     */
    public function select(array $contents = [], array $order = [], SQLBuilderInterface $builder = null)
    {
        if (!($builder instanceof SQLBuilderInterface)) {
            $template = empty($contents) ? static::SELECT_ALL_TEMPLATE : static::SELECT_TEMPLATE;
            $builder  = $this->getBuilder()->setTemplate($template);
        }

        $table = $this->giGetSqlFactory()->createFieldExpression($this->getTable()->getFullName());
        $builder->setParam('table', $table->toString());

        if (!empty($contents)) {
            $predicateList = ($builder instanceof SQLBuilderInterface)
                ? $this->giGetSqlFactory()->createAndAssignPredicates($contents, $this->getTable())
                : $this->giGetSqlFactory()->createAndAssignPredicates($contents);
            $builder->setParam('predicate-list', $predicateList->toString());
        }

        $builder->addOrder($order);

        return $builder->toString();
    }
}