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
namespace GI\Logger;

use GI\Logger\View\View;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\FileSystem\FSO\FSOFile\Collection\HashSet\HashSetInterface as LogFilesHashSetInterface;
use GI\Logger\View\ViewInterface;

class Logger implements LoggerInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var LogFilesHashSetInterface
     */
    private $logFiles;


    /**
     * Logger constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->view = $this->giGetDi(ViewInterface::class,View::class);

        $this->createLogFiles();
    }

    /**
     * @return ViewInterface
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return LogFilesHashSetInterface
     */
    protected function getLogFiles()
    {
        return $this->logFiles;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createLogFiles()
    {
        try {
            $this->logFiles = $this->giGetDi(LogFilesHashSetInterface::class);
        } catch (\Exception $e) {
            $this->giThrowDependencyException('Log files');
        }

        return $this;
    }

    /**
     * @param string $logName
     * @param string $title
     * @param mixed $text
     * @return static
     * @throws \Exception
     */
    public function log(string $logName, string $title, $text)
    {
        $contents = $this->getView()->setDate($this->createDate())->setTitle($title)->setText($text)->toString();

        $this->getLogFiles()->get($logName)->appendContents($contents);

        return $this;
    }

    /**
     * @return \DateTime
     */
    protected function createDate()
    {
        return new \DateTime();
    }
}