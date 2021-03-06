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
namespace GI\GI\RDB\ORM\Builder;

use GI\GI\RDB\ORM\Builder\Table\Builder as TableBuilder;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Driver\DriverInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\GI\RDB\ORM\Builder\Table\BuilderInterface as TableBuilderInterface;
use GI\RDB\Meta\Table\TableInterface;

abstract class AbstractBuilder implements BuilderInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var FSODirInterface
     */
    private $ormDir;

    /**
     * @var TableBuilderInterface[]
     */
    private $tableBuilders = [];


    /**
     * AbstractBuilder constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->driver = $this->createDriver();
        $this->ormDir = $this->createOrmDir();

        $this->createTableBuilders();
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createTableBuilders()
    {
        foreach ($this->getDriver()->getTableList()->getItems() as $table) {
            $this->tableBuilders[] = $this->createTableBuilder($table);
        }

        return $this;
    }

    /**
     * @param TableInterface $table
     * @return TableBuilderInterface
     * @throws \Exception
     */
    protected function createTableBuilder(TableInterface $table)
    {
        try {
            $builder = $this->giGetDi(
                TableBuilderInterface::class,
                null,
                [$table, $this->getOrmDir(), $this->getOrmNamespace(), $this->getBaseNamespace()]
            );
        } catch (\Exception $exception) {
            $builder = new TableBuilder(
                $table, $this->getOrmDir(), $this->getOrmNamespace(), $this->getBaseNamespace()
            );
        }

        return $builder;
    }

    /**
     * @return DriverInterface
     */
    protected function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return FSODirInterface
     */
    protected function getOrmDir()
    {
        return $this->ormDir;
    }

    /**
     * @return TableBuilderInterface[]
     */
    protected function getTableBuilders()
    {
        return $this->tableBuilders;
    }

    /**
     * @return DriverInterface
     */
    abstract protected function createDriver();

    /**
     * @return FSODirInterface
     */
    abstract protected function createOrmDir();

    /**
     * @return string
     */
    abstract protected function getServiceLocatorTrait();

    /**
     * @return string
     */
    abstract protected function getOrmNamespace();

    /**
     * @return string
     */
    abstract protected function getBaseNamespace();

    /**
     * @return static
     * @throws \Exception
     */
    public function create()
    {
        foreach ($this->getTableBuilders() as $tableBuilder) {
            $tableBuilder->create();
        }

        //todo factory

        return $this;
    }
}