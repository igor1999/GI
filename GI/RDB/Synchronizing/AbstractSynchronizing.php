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
namespace GI\RDB\Synchronizing;

use GI\RDB\Synchronizing\ResultMessageCreator\ResultMessageCreator;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Driver\DriverInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\RDB\Synchronizing\ResultMessageCreator\ResultMessageCreatorInterface;
use GI\RDB\Synchronizing\Context\ContextInterface;

abstract class AbstractSynchronizing implements SynchronizingInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var FSOFileInterface
     */
    private $dumpFile;

    /**
     * @var ResultMessageCreatorInterface
     */
    private $resultMessageCreator;


    /**
     * AbstractSynchronizing constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createDriver();

        $this->dumpFile = $this->createContext()->getDumpFile();

        $this->resultMessageCreator = $this->getGiServiceLocator()->getDependency(
            ResultMessageCreatorInterface::class, ResultMessageCreator::class
        );
    }

    /**
     * @return DriverInterface
     */
    protected function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createDriver()
    {
        try {
            $this->driver = $this->getGiServiceLocator()->getDependency(DriverInterface::class);
        } catch (\Exception $e) {
            $this->getGiServiceLocator()->throwDependencyException('RDB Driver');
        }

        return $this;
    }

    /**
     * @return ContextInterface
     * @throws \Exception
     */
    protected function createContext()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->getGiServiceLocator()->getDependency(ContextInterface::class);
        } catch (\Exception $e) {
            $context = null;
            $this->getGiServiceLocator()->throwDependencyException('Context');
        }

        return $context;
    }

    /**
     * @return FSOFileInterface
     */
    protected function getDumpFile()
    {
        return $this->dumpFile;
    }

    /**
     * @return ResultMessageCreatorInterface
     */
    protected function getResultMessageCreator()
    {
        return $this->resultMessageCreator;
    }

    /**
     * @return string
     */
    public function getResultMessage()
    {
        return $this->getResultMessageCreator()->getMessage();
    }

    /**
     * @return static
     */
    public function printResultMessage()
    {
        echo $this->getResultMessage();

        return $this;
    }
}