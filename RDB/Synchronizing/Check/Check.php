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
namespace GI\RDB\Synchronizing\Check;

use GI\RDB\Synchronizing\AbstractSynchronizing;
use GI\RDB\Synchronizing\Check\Comparator\Comparator;
use GI\RDB\Synchronizing\View\Check\Check as CheckView;
use GI\RDB\Synchronizing\Check\Reader\Reader;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\RDB\Synchronizing\View\Check\CheckInterface as CheckViewInterface;
use GI\RDB\Synchronizing\Check\Reader\ReaderInterface;
use GI\RDB\Synchronizing\Check\Comparator\ComparatorInterface;

class Check extends AbstractSynchronizing implements CheckInterface
{
    /**
     * @var FSOFileInterface
     */
    private $resultFile;

    /**
     * @var ComparatorInterface
     */
    private $comparator;

    /**
     * @var CheckViewInterface
     */
    private $view;

    /**
     * @var ReaderInterface
     */
    private $reader;


    /**
     * Dump constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->resultFile = $this->createContext()->getResultFile();

        $this->comparator = $this->giGetDi(ComparatorInterface::class, Comparator::class);

        $this->view = $this->giGetDi(CheckViewInterface::class, CheckView::class);

        $this->reader = $this->giGetDi(ReaderInterface::class, Reader::class);
    }

    /**
     * @return FSOFileInterface
     */
    protected function getResultFile()
    {
        return $this->resultFile;
    }

    /**
     * @return ComparatorInterface
     */
    protected function getComparator()
    {
        return $this->comparator;
    }

    /**
     * @return CheckViewInterface
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return ReaderInterface
     */
    protected function getReader()
    {
        return $this->reader;
    }

    /**
     * @return static
     */
    public function check()
    {
        try {
            $dumpContents     = $this->getReader()->readFile($this->getDumpFile());
            $databaseContents = $this->getDriver()->getTableList()->extract();

            $this->getComparator()->compare($dumpContents, $databaseContents);

            $this->getView()->setDumpOnly($this->getComparator()->getDumpOnly())
                ->setDatabaseOnly($this->getComparator()->getDatabaseOnly())
                ->setUnequals($this->getComparator()->getUnequals())
                ->save($this->getResultFile());

            if ($this->getComparator()->isOk()) {
                $this->getResultMessageCreator()->createNoDiff();
            } else {
                $this->getResultMessageCreator()->createDiff(
                    $this->getComparator()->getCountOfDumpOnly(),
                    $this->getComparator()->getCountOfDatabaseOnly(),
                    $this->getComparator()->getCountOfUnequals()
                );
            }
        } catch (\Exception $e) {
            $this->getResultMessageCreator()->createError($e->getMessage());
        }

        return $this;
    }
}