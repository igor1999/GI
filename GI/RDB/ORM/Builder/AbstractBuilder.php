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
namespace GI\RDB\ORM\Builder;

use GI\RDB\ORM\Builder\Table\Builder as TableBuilder;
use GI\RDB\ORM\Builder\View\Factory\ClassView\View as FactoryClassView;
use GI\RDB\ORM\Builder\View\Factory\InterfaceView\View as FactoryInterfaceView;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Driver\DriverInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\RDB\ORM\Builder\Table\BuilderInterface as TableBuilderInterface;
use GI\RDB\Meta\Table\TableInterface;
use GI\RDB\ORM\Builder\View\Factory\ClassView\ViewInterface as FactoryClassViewInterface;
use GI\RDB\ORM\Builder\View\Factory\InterfaceView\ViewInterface as FactoryInterfaceViewInterface;

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
     * @var FactoryClassViewInterface
     */
    private $factoryClassView;

    /**
     * @var FactoryInterfaceViewInterface
     */
    private $factoryInterfaceView;


    /**
     * AbstractBuilder constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->driver = $this->createDriver();
        $this->ormDir = $this->createOrmDir();

        $this->createTableBuilders();

        $this->factoryClassView = $this->giGetDi(
            FactoryClassViewInterface::class, FactoryClassView::class
        );

        $this->factoryInterfaceView = $this->giGetDi(
            FactoryInterfaceViewInterface::class, FactoryInterfaceView::class
        );
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
     * @return FactoryClassViewInterface
     */
    protected function getFactoryClassView()
    {
        return $this->factoryClassView;
    }

    /**
     * @return FactoryInterfaceViewInterface
     */
    protected function getFactoryInterfaceView()
    {
        return $this->factoryInterfaceView;
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
        $this->createEntities()->createFactory();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createEntities()
    {
        foreach ($this->getTableBuilders() as $tableBuilder) {
            $tableBuilder->create();
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createFactory()
    {
        $dir = $this->getOrmDir()->createChildDir('Factory');

        $this->getFactoryClassView()
            ->setDriver($this->getDriver())
            ->setORMNamespace($this->getOrmNamespace())
            ->setServiceLocatorTrait($this->getServiceLocatorTrait())
            ->save($dir->createChildFile('Factory.php')->create());

        $this->getFactoryInterfaceView()
            ->setDriver($this->getDriver())
            ->setORMNamespace($this->getOrmNamespace())
            ->setServiceLocatorTrait($this->getServiceLocatorTrait())
            ->save($dir->createChildFile('FactoryInterface.php')->create());

        return $this;
    }
}