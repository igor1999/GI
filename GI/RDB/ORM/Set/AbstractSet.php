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
namespace GI\RDB\ORM\Set;

use GI\RDB\ORM\Record\AbstractRecord;
use GI\RDB\ORM\Set\Index\Collection\Collection as IndexCollection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\ORM\Record\RecordInterface;
use GI\RDB\Driver\DriverInterface;
use GI\RDB\Meta\Table\TableInterface;
use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;
use GI\RDB\ORM\Set\Index\Collection\CollectionInterface as IndexCollectionInterface;
use GI\RDB\SQL\Cortege\Predicates\Join\JoinInterface;

abstract class AbstractSet implements SetInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var RecordInterface
     */
    private $templateItem;

    /**
     * @var RecordInterface[]
     */
    private $items = [];

    /**
     * @var IndexCollectionInterface
     */
    private $indexList;


    /**
     * AbstractSet constructor.
     */
    public function __construct()
    {
        $this->templateItem = $this->createTemplateItem();
    }

    /**
     * @return RecordInterface
     */
    protected function getTemplateItem()
    {
        return $this->templateItem;
    }

    /**
     * @return RecordInterface
     */
    abstract protected function createTemplateItem();

    /**
     * @return IndexCollectionInterface
     * @throws \Exception
     */
    public function getIndexList()
    {
        if (!($this->indexList instanceof IndexCollectionInterface)) {
            $this->indexList = $this->getGiServiceLocator()->getDependency(
                IndexCollectionInterface::class, IndexCollection::class, [$this]
            );
        }

        return $this->indexList;
    }

    /**
     * @return TableInterface
     */
    public function getTable()
    {
        return $this->getTemplateItem()->getTable();
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->getTable()->getDriver();
    }

    /**
     * @return string
     */
    public function getItemClass()
    {
        return get_class($this->getTemplateItem());
    }

    /**
     * @param array[] $contents
     * @return static
     * @throws \Exception
     */
    protected function hydrateFromDB(array $contents)
    {
        $this->clean();

        $methodReflection = $this->getGiServiceLocator()->getClassMeta($this->getItemClass())->getMethods()->get(__FUNCTION__);

        foreach ($contents as $itemContent) {
            $methodReflection->execute($this->add(), [$itemContent]);
        }

        $this->getIndexList()->refresh();

        return $this;
    }

    /**
     * @return array[]
     * @throws \Exception
     */
    public function extract()
    {
        $result = [];

        foreach ($this->getItems() as $item) {
            $result[] = $item->extract();
        }

        return $result;
    }

    /**
     * @param array[] $contents
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $contents)
    {
        $this->clean();

        foreach ($contents as $itemContent) {
            $this->add()->hydrate($itemContent);
        }

        $this->getIndexList()->refresh();

        return $this;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index)
    {
        return isset($this->items[$index]);
    }

    /**
     * @param int $index
     * @return RecordInterface
     * @throws \Exception
     */
    public function get(int $index)
    {
        if (!$this->has($index)) {
            $this->getGiServiceLocator()->throwNotInScopeException($index);
        }

        return $this->items[$index];
    }

    /**
     * @return RecordInterface
     * @throws \Exception
     */
    public function getFirst()
    {
        return $this->get(0);
    }

    /**
     * @return RecordInterface
     * @throws \Exception
     */
    public function getLast()
    {
        return $this->get($this->getLength() - 1);
    }

    /**
     * @return RecordInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @return RecordInterface
     * @throws \Exception
     */
    public function add()
    {
        $this->items[] = $this->createTemplateItem();

        return $this->getLast();
    }

    /**
     * @param int $index
     * @return RecordInterface
     * @throws \Exception
     */
    public function addBefore(int $index)
    {
        if (!$this->has($index)) {
            $item = $this->add();
        } else {
            array_splice($this->items, $index, 0, [$this->createTemplateItem()]);
            $item = $this->get($index);
        }

        return $item;
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index)
    {
        if ($result = $this->has($index)) {
            array_splice($this->items, $index, 1);
        }

        return $result;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function clean()
    {
        $this->items = [];

        $this->getIndexList()->refresh();

        return $this;
    }

    /**
     * @param array $contents
     * @param array $order
     * @param SQLBuilderInterface|null $builder
     * @return static
     * @throws \Exception
     */
    protected function fill(array $contents = [], array $order = [], SQLBuilderInterface $builder = null)
    {
        $this->hydrateFromDB($this->getTable()->select($contents, $order, $builder));

        return $this;
    }

    /**
     * @param array $contents
     * @param array $order
     * @return static
     * @throws \Exception
     */
    public function select(array $contents = [], array $order = [])
    {
        $this->fill($contents, $order);

        return $this;
    }

    /**
     * @param string $proxyClass
     * @param array $contents
     * @param array $order
     * @param SQLBuilderInterface|null $builder
     * @return static
     * @throws \Exception
     */
    protected function fillByProxy(
        string $proxyClass, array $contents = [], array $order = [], SQLBuilderInterface $builder = null)
    {
        if (!is_a($proxyClass, SetInterface::class, true)
                && !is_a($proxyClass, RecordInterface::class, true)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Proxy class', $proxyClass, 'SetInterface or RecordInterface');
        }

        $joinFields = $this->getProxyJoinFields($proxyClass);

        if (empty($joinFields)) {
            $this->getGiServiceLocator()->throwNotFoundException('Join fields with proxy class', $proxyClass);
        }

        /** @var SetInterface|RecordInterface $proxyObject */
        $proxyObject = $this->getGiServiceLocator()->getClassMeta($proxyClass)->create();

        $joinPredicates   = $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()->createJoinPredicates(
            $joinFields, $this->getTable(), $proxyObject->getTable()
        );

        $assignPredicates = $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()->createAndAssignPredicates($contents, $proxyObject->getTable());

        $proxyTable = $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()->createFieldExpression($proxyObject->getTable()->getFullName());

        if (!($builder instanceof SQLBuilderInterface)) {
            $builder = $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()
                ->createSQLBuilder()
                ->setTemplate($this->getCommonProxyTemplate())
                ->addOrder($order);
        }

        $builder->setParam('proxy-table', $proxyTable->toString())
            ->setParam('join', $joinPredicates->toString())
            ->setParam('assign', $assignPredicates->toString());

        $this->fill($contents, $order, $builder);

        return $this;
    }

    /**
     * @param string $proxyClass
     * @return string[]
     * @throws \Exception
     */
    protected function getProxyJoinFields(string $proxyClass)
    {
        $methodReflections = $this->getGiServiceLocator()->getClassMeta($this->getItemClass())
            ->getMethods()
            ->findByDescriptorName($proxyClass);

        $joinFields = [];

        foreach ($methodReflections as $methodReflection) {
            $myField = $methodReflection->getDescriptor(AbstractRecord::DB_EXTRACTION_DESCRIPTOR);
            if (empty($myField)) {
                $myField = $methodReflection->getDescriptor(AbstractRecord::DB_RELATION_DESCRIPTOR);
            }

            $proxyField = $methodReflection->getDescriptor($proxyClass);

            $joinFields[$myField] = $proxyField;
        }

        return $joinFields;
    }

    /**
     * @return string
     */
    protected function getCommonProxyTemplate()
    {
        return '
            SELECT %table%.*
            FROM %table%
                INNER JOIN %proxy-table%
                    ON %join%
                    AND %assign%
            %order%        
        ';
    }

    /**
     * @param string $proxyClass
     * @param array $contents
     * @param array $order
     * @return static
     * @throws \Exception
     */
    public function selectByProxy(string $proxyClass, array $contents = [], array $order = [])
    {
        $this->fillByProxy($proxyClass, $contents, $order);

        return $this;
    }

    /**
     * @param string[] $nextClasses
     * @return JoinInterface[]
     * @throws \Exception
     */
    public function getCascadeJoinPredicates(array $nextClasses)
    {
        if (empty($nextClasses)) {
            $result = [];
        } else {
            $nextClass = array_shift($nextClasses);
            if (!is_a($nextClass, SetInterface::class, true)) {
                $this->getGiServiceLocator()->throwInvalidTypeException('Cascade class', $nextClass, 'SetInterface');
            }

            $joinFields = $this->getProxyJoinFields($nextClass);
            if (empty($joinFields)) {
                $this->getGiServiceLocator()->throwNotFoundException('Join fields with proxy class', $nextClass);
            }

            /** @var SetInterface $nextSet */
            $nextSet = $this->getGiServiceLocator()->getClassMeta($nextClass)->create();

            $joinPredicates = $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()->createJoinPredicates(
                $joinFields, $this->getTable(), $nextSet->getTable()
            );

            $result = $nextSet->getCascadeJoinPredicates($nextClasses);
            array_unshift($result, $joinPredicates);
        }

        return $result;
    }

    /**
     * @param string[] $cascadeClasses
     * @param array $contents
     * @param array $order
     * @return static
     * @throws \Exception
     */
    public function selectByCascade(array $cascadeClasses, array $contents = [], array $order = [])
    {
        $firstClass = array_shift($cascadeClasses);
        if (!is_a($firstClass, SetInterface::class, true)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Cascade class', $firstClass, 'SetInterface');
        }

        /** @var SetInterface $firstSet */
        $firstSet = $this->getGiServiceLocator()->getClassMeta($firstClass)->create();

        $cascadeClasses[] = static::class;
        $cascadeJoinPredicates = $firstSet->getCascadeJoinPredicates($cascadeClasses);

        $sql = 'SELECT {{%result-table%}}.*' . PHP_EOL . 'FROM {{%first-table%}}' . PHP_EOL;

        $builder = $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()->createSQLBuilder()
            ->setParam('result-table', $this->getTable()->getFullName())
            ->setParam('first-table', $firstSet->getTable()->getFullName())
            ->addOrder($order);

        foreach ($cascadeJoinPredicates as $index => $cascadeJoinPredicate) {
            $joinSql = 'INNER JOIN {{%table%}}' . PHP_EOL . 'ON %condition%' . PHP_EOL;
            if ($index == 0) {
                $joinSql .= 'AND %assigns%' . PHP_EOL;
            }

            $builder->setTemplate($joinSql)
                ->setParam('table', $cascadeJoinPredicate->getJoinTable()->getFullName())
                ->setParam('condition', $cascadeJoinPredicate->toString());
            if ($index == 0) {
                $assignPredicates = $this->getGiServiceLocator()->getRdbDi()->getSqlFactory()
                    ->createAndAssignPredicates($contents, $firstSet->getTable());
                $builder->setParam('assigns', $assignPredicates->toString());
            }

            $sql .= $builder->toString();
        }

        $sql .= '%order%';
        $builder->setTemplate($sql);

        $data = $this->getDriver()->fetchAll($builder->toString(), $contents);
        $this->hydrateFromDB($data);

        return $this;
    }

    /**
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function insert(SQLBuilderInterface $builder = null)
    {
        $result = 0;

        foreach ($this->getItems() as $item) {
            $result += $item->insert($builder);
        }

        return $result;
    }

    /**
     * @param SQLBuilderInterface|null $builder
     * @return int
     * @throws \Exception
     */
    public function delete(SQLBuilderInterface $builder = null)
    {
        $result = 0;

        foreach ($this->getItems() as $item) {
            $result += $item->delete($builder);
        }

        return $result;
    }

    /**
     * @param SQLBuilderInterface|null $builder
     * @return int
     */
    public function update(SQLBuilderInterface $builder = null)
    {
        $result = 0;

        foreach ($this->getItems() as $item) {
            $result += $item->update($builder);
        }

        return $result;
    }
}