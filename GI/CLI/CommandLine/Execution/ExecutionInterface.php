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

interface ExecutionInterface
{
    const WINDOWS_BACKGROUND_PROCESS_TEMPLATE = 'start /b %s';

    const LINUX_BACKGROUND_PROCESS_TEMPLATE   = '%s > /dev/null &';


    /**
     * @return string
     */
    public function execute();

    /**
     * @return array
     * @throws \Exception
     */
    public function getJSON();

    /**
     * @return static
     */
    public function startBackgroundProcess();
}