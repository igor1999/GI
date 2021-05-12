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
namespace GI\RDB\ORM\Record;

use GI\RDB\Driver\Exception\Fetch\Exception as FetchException;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ArrayExchangeTrait;
use GI\RDB\ORM\Exception\ExceptionAwareTrait;

use GI\RDB\Driver\DriverInterface;
use GI\RDB\ORM\Set\SetInterface;
use GI\RDB\SQL\Builder\BuilderInterface as SQLBuilderInterface;

abstract class AbstractRecord implements RecordInterface
{
    use ServiceLocatorAwareTrait, ArrayExchangeTrait, ExceptionAwareTrait;


    const DB_EXTRACTION_DESCRIPTOR = 'to-db';

    const DB_HYDRATION_DESCRIPTOR  = 'from-db';

    const DB_RELATION_DESCRIPTOR  = 'relate-db';


    /**
     * AbstractRecord constructor.
     * @param mixed|null $primaryKey
     * @throws \Exception
     */
    public function __construct($primaryKey = null)
    {
        if (!empty($primaryKey)) {
            try {
                $this->fill($primaryKey);
            } catch (\Exception $exception) {
                if ($exception instanceof FetchException) {
                    $this->throwORMNotFoundException();
                } else {
                    throw $exception;
                }
            }
        }
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->getTable()->getDriver();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function extractToDB()
    {
        return $this->giGetClassMeta()->extract($this, static::DB_EXTRACTION_DESCRIPTOR);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function extractPrimaryToDB()
    {
        return array_intersect_key($this->extractToDB(), $this->getTable()->getColumnList()->getPrimary());
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function extractNonPrimaryToDB()
    {
        return array_intersect_key($this->extractToDB(), $this->getTable()->getColumnList()->getNonPrimary());
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function extractNonIdentityToDB()
    {
        return array_intersect_key($this->extractToDB(), $this->getTable()->getColumnList()->getNonIdentity());
    }

    /**
     * @param array $data
     * @return static
     * @throws \Exception
     */
    protected function hydrateFromDB(array $data)
    {
        $this->giGetClassMeta()->hydrate($this, $data, static::DB_HYDRATION_DESCRIPTOR);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function hydrateIdentityFromDB()
    {
        try {
            $name  = $this->getTable()->getColumnList()->getIdentity()->getName();
            $value = $this->getTable()->getLastInsertId();

            $this->hydrateFromDB([$name => $value]);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param mixed $primaryKey
     * @param SQLBuilderInterface|null $builder
     * @return static
     * @throws \Exception
     */
    protected function fill($primaryKey, SQLBuilderInterface $builder = null)
    {
        $data = $this->getTable()->find($primaryKey, $builder);
        $this->hydrateFromDB($data);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function refresh()
    {
        $this->fill($this->extractPrimaryToDB());

        return $this;
    }

    /**
     * @param SQLBuilderInterface|null $builder
     * @return static
     * @throws \Exception
     */
    public function insert(SQLBuilderInterface $builder = null)
    {
        $result = $this->getTable()->insert($this->extractNonIdentityToDB(), $builder);

        if (empty($result) && !$this->isDuplicatedError()) {
            $this->throwORMNotAffectedException();
        }

        $this->hydrateIdentityFromDB();

        return $this;
    }

    /**
     * @param SQLBuilderInterface|null $builder
     * @return static
     * @throws \Exception
     */
    public function delete(SQLBuilderInterface $builder = null)
    {
        $result = $this->getTable()->delete($this->extractPrimaryToDB(), $builder);

        if (empty($result)) {
            $this->throwORMNotAffectedException();
        }

        if ($result > 1) {
            $this->throwORMDuplicatedException();
        }

        return $this;
    }

    /**
     * @param SQLBuilderInterface|null $builder
     * @return static
     * @throws \Exception
     */
    public function update(SQLBuilderInterface $builder = null)
    {
        $result = $this->getTable()->update($this->extractNonPrimaryToDB(), $this->extractPrimaryToDB(), $builder);

        if ($result > 1) {
            $this->throwORMDuplicatedException();
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isDuplicatedError()
    {
        return $this->getTable()->getDriver()->isDuplicatedError();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasDuplicatedKey(string $key)
    {
        return $this->getTable()->getDriver()->hasDuplicatedKey($key);
    }

    /**
     * @param string $class
     * @return RecordInterface
     * @throws \Exception
     */
    protected function getRelatedRecord(string $class)
    {
        if (!is_a($class, RecordInterface::class, true)) {
            $this->giThrowInvalidTypeException('Related class', $class, 'RecordInterface');
        }

        $data = $this->giGetClassMeta()->getMethods()->extract($this, $class);

        /** @var RecordInterface $result */
        $result = $this->giGetClassMeta($class)->create([$data]);

        return $result;
    }

    /**
     * @param string $class
     * @param array $order
     * @return SetInterface
     * @throws \Exception
     */
    protected function getRelatedSet(string $class, array $order = [])
    {
        if (!is_a($class, SetInterface::class, true)) {
            $this->giThrowInvalidTypeException('Related class', $class, 'SetInterface');
        }

        /** @var SetInterface $result */
        $result = $this->giGetClassMeta($class)->create();

        $data = $this->giGetClassMeta()->getMethods()->extract($this, $class);

        $result->select($data, $order);

        return $result;
    }

    /**
     * @param string $setClass
     * @param string $proxyClass
     * @param array $order
     * @return SetInterface
     * @throws \Exception
     */
    protected function getRelatedSetByProxy(string $setClass, string $proxyClass, array $order = [])
    {
        if (!is_a($setClass, SetInterface::class, true)) {
            $this->giThrowInvalidTypeException('Related class', $setClass, 'SetInterface');
        }

        if (!is_a($proxyClass, SetInterface::class, true)
                || !is_a($proxyClass, RecordInterface::class, true)) {
            $this->giThrowInvalidTypeException('Related class', $proxyClass, 'SetInterface or RecordInterface');
        }

        /** @var SetInterface $result */
        $result = $this->giGetClassMeta($setClass)->create();

        $data = $this->giGetClassMeta()->getMethods()->extract($this, $proxyClass);

        $result->selectByProxy($proxyClass, $data, $order);

        return $result;
    }
}