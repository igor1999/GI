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
namespace GI\GI\RDB\ORM\Builder\Table;

use GI\RDB\ORM\Builder\View\Entity\Record\ClassView\View as RecordClassView;
use GI\RDB\ORM\Builder\View\Entity\Record\InterfaceView\View as RecordInterfaceView;
use GI\RDB\ORM\Builder\View\Entity\Set\ClassView\View as SetClassView;
use GI\RDB\ORM\Builder\View\Entity\Set\InterfaceView\View as SetInterfaceView;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Meta\Table\TableInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\ClassView\ViewInterface as RecordClassViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\InterfaceView\ViewInterface as RecordInterfaceViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Set\ClassView\ViewInterface as SetClassViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Set\InterfaceView\ViewInterface as SetInterfaceViewInterface;

class Builder implements BuilderInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @var FSODirInterface
     */
    private $ormDir;

    /**
     * @var string
     */
    private $ormNamespace;

    /**
     * @var string
     */
    private $baseNamespace;

    /**
     * @var RecordClassViewInterface
     */
    private $recordClassView;

    /**
     * @var RecordInterfaceViewInterface
     */
    private $recordInterfaceView;

    /**
     * @var SetClassViewInterface
     */
    private $setClassView;

    /**
     * @var SetInterfaceViewInterface
     */
    private $setInterfaceView;


    /**
     * Builder constructor.
     * @param TableInterface $table
     * @param FSODirInterface $ormDir
     * @param string $ormNamespace
     * @param string $baseNamespace
     * @throws \Exception
     */
    public function __construct(
        TableInterface $table, FSODirInterface $ormDir, string $ormNamespace, string $baseNamespace)
    {
        $this->table         = $table;
        $this->ormDir        = $ormDir;
        $this->ormNamespace  = $ormNamespace;
        $this->baseNamespace = $baseNamespace;

        $this->recordClassView = $this->giGetDi(RecordClassViewInterface::class, RecordClassView::class);

        $this->recordInterfaceView = $this->giGetDi(
            RecordInterfaceViewInterface::class, RecordInterfaceView::class
        );

        $this->setClassView = $this->giGetDi(SetClassViewInterface::class, SetClassView::class);

        $this->setInterfaceView = $this->giGetDi(
            SetInterfaceViewInterface::class, SetInterfaceView::class
        );
    }

    /**
     * @return TableInterface
     */
    protected function getTable()
    {
        return $this->table;
    }

    /**
     * @return FSODirInterface
     */
    protected function getOrmDir()
    {
        return $this->ormDir;
    }

    /**
     * @return string
     */
    protected function getOrmNamespace()
    {
        return $this->ormNamespace;
    }

    /**
     * @param string $ormNamespace
     * @return static
     */
    protected function setOrmNamespace(string $ormNamespace)
    {
        $this->ormNamespace = $ormNamespace;

        return $this;
    }

    /**
     * @return string
     */
    protected function getBaseNamespace()
    {
        return $this->baseNamespace;
    }

    /**
     * @param string $baseNamespace
     * @return static
     */
    protected function setBaseNamespace(string $baseNamespace)
    {
        $this->baseNamespace = $baseNamespace;

        return $this;
    }

    /**
     * @return RecordClassViewInterface
     */
    protected function getRecordClassView()
    {
        return $this->recordClassView;
    }

    /**
     * @return RecordInterfaceViewInterface
     */
    protected function getRecordInterfaceView()
    {
        return $this->recordInterfaceView;
    }

    /**
     * @return SetClassViewInterface
     */
    protected function getSetClassView()
    {
        return $this->setClassView;
    }

    /**
     * @return SetInterfaceViewInterface
     */
    protected function getSetInterfaceView()
    {
        return $this->setInterfaceView;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function create()
    {
        $childDir = $this->getTable()->getDir();
        $dir      = $this->getOrmDir()->createChildDir($childDir);

        $this->getRecordClassView()
            ->setTable($this->getTable())
            ->setORMNamespace($this->ormNamespace)
            ->setBaseNamespace($this->baseNamespace)
            ->save($dir->createChildFile('Record.php')->create());

        $this->getRecordInterfaceView()
            ->setTable($this->getTable())
            ->setORMNamespace($this->ormNamespace)
            ->setBaseNamespace($this->baseNamespace)
            ->save($dir->createChildFile('RecordInterface.php')->create());

        $this->getSetClassView()
            ->setTable($this->getTable())
            ->setORMNamespace($this->ormNamespace)
            ->setBaseNamespace($this->baseNamespace)
            ->save($dir->createChildFile('Set.php')->create());

        $this->getSetInterfaceView()
            ->setTable($this->getTable())
            ->setORMNamespace($this->ormNamespace)
            ->setBaseNamespace($this->baseNamespace)
            ->save($dir->createChildFile('SetInterface.php')->create());

        return $this;
    }
}