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
namespace GI\CLI\CommandLine\Execution;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\CLI\CommandLine\CommandLineInterface;

class Execution implements ExecutionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var CommandLineInterface
     */
    private $commandLine;


    /**
     * Command constructor.
     * @param CommandLineInterface $commandLine
     */
    public function __construct(CommandLineInterface $commandLine)
    {
        $this->commandLine = $commandLine;
    }

    /**
     * @return CommandLineInterface
     */
    protected function getCommandLine()
    {
        return $this->commandLine;
    }

    /**
     * @return mixed|string
     */
    public function execute()
    {
        $command = $this->getCommandLine()->toString();

        return `$command`;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getJSON()
    {
        return $this->giCreateJsonDecoder()->decode($this->execute());
    }

    /**
     * @return static
     */
    public function startBackgroundProcess()
    {
        if ($this->giGetServer()->isOSWindows()) {
            $command = sprintf(self::WINDOWS_BACKGROUND_PROCESS_TEMPLATE, $this->getCommandLine()->toString());

            pclose(popen($command, 'r'));
        } else {
            $command = sprintf(self::LINUX_BACKGROUND_PROCESS_TEMPLATE, $this->getCommandLine()->toString());

            exec($command);
        }

        return $this;
    }
}