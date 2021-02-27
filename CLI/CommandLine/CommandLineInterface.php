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
namespace GI\CLI\CommandLine;

use GI\CLI\CLIInterface;
use GI\CLI\CommandLine\Argument\ArgumentInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\Pattern\Closing\ClosingInterface;
use GI\Pattern\StringConvertable\StringConvertableInterface;
use GI\Pattern\ArrayExchange\ArrayExchangeInterface;
use GI\CLI\CommandLine\Execution\ExecutionInterface;

interface CommandLineInterface
    extends CLIInterface, ClosingInterface, StringConvertableInterface, ArrayExchangeInterface
{
    const SEPARATOR = ' ';


    /**
     * @return ExecutionInterface
     */
    public function getExecutionProcessor();

    /**
     * @param int $position
     * @return bool
     */
    public function has(int $position);

    /**
     * @param int $position
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function get(int $position);

    /**
     * @param int $position
     * @param mixed $default
     * @return string
     */
    public function getValueOptional(int $position, $default = '');

    /**
     * @return ArgumentInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param \Closure $filter
     * @param bool $withScript
     * @param bool $withCommand
     * @return static
     * @throws \Exception
     */
    public function filter(\Closure $filter, bool $withScript = false, bool $withCommand = false);

    /**
     * @param string $raw
     * @param bool $withScript
     * @param bool $withCommand
     * @return static
     * @throws \Exception
     */
    public function filterRaws(string $raw, bool $withScript = false, bool $withCommand = false);

    /**
     * @param string $name
     * @param bool $withScript
     * @param bool $withCommand
     * @return static
     * @throws \Exception
     */
    public function filterNames(string $name, bool $withScript = false, bool $withCommand = false);

    /**
     * @param string $value
     * @param bool $withScript
     * @param bool $withCommand
     * @return static
     * @throws \Exception
     */
    public function filterValues(string $value, bool $withScript = false, bool $withCommand = false);

    /**
     * @param string $name
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function findByName(string $name);

    /**
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public function findValueByName(string $name);

    /**
     * @param string $name
     * @param mixed $default
     * @return string
     */
    public function findValueByNameOptional(string $name, $default = '');

    /**
     * @return string
     * @throws \Exception
     */
    public function getRoute();

    /**
     * @return string
     * @throws \Exception
     */
    public function getSession();

    /**
     * @return string
     * @throws \Exception
     */
    public function getDemon();

    /**
     * @return string
     * @throws \Exception
     */
    public function getJob();

    /**
     * @param bool $base64
     * @return static
     */
    public function setBase64(bool $base64);

    /**
     * @param ArgumentInterface $item
     * @return static
     * @throws \Exception
     */
    public function add(ArgumentInterface $item);

    /**
     * @param string $raw
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function createAndAdd(string $raw = '');

    /**
     * @param string $name
     * @param string $value
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function createAndAddNamed(string $name, string $value, bool $base64 = false);

    /**
     * @param int $position
     * @param ArgumentInterface $item
     * @return static
     * @throws \Exception
     */
    public function insert(int $position, ArgumentInterface $item);

    /**
     * @param int $position
     * @param string $raw
     * @return static
     * @throws \Exception
     */
    public function createAndInsert(int $position, string $raw);

    /**
     * @param int $position
     * @param string $name
     * @param string $value
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function createAndInsertNamed(int $position, string $name, string $value, bool $base64 = false);

    /**
     * @param int $position
     * @param ArgumentInterface $item
     * @return static
     * @throws \Exception
     */
    public function set(int $position, ArgumentInterface $item);

    /**
     * @param int $position
     * @param string $raw
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function createAndSet(int $position, string $raw = '');

    /**
     * @param int $position
     * @param string $name
     * @param string $value
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function createAndSetNamed(int $position, string $name, string $value, bool $base64 = false);

    /**
     * @param string $route
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addRoute(string $route, bool $base64 = false);

    /**
     * @param string $sessionID
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addSession(string $sessionID, bool $base64 = false);

    /**
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addCurrentSession(bool $base64 = false);

    /**
     * @param string $demon
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addDemon(string $demon, bool $base64 = false);

    /**
     * @param string $job
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addJob(string $job, bool $base64 = false);

    /**
     * @param int $position
     * @return bool
     * @throws \Exception
     */
    public function remove(int $position);

    /**
     * @param string $name
     * @return static
     * @throws \Exception
     */
    public function removeByName(string $name);

    /**
     * @return static
     * @throws \Exception
     */
    public function removeRoute();

    /**
     * @return static
     * @throws \Exception
     */
    public function removeSession();

    /**
     * @return static
     * @throws \Exception
     */
    public function removeDemon();

    /**
     * @return static
     * @throws \Exception
     */
    public function removeJob();

    /**
     * @return static
     * @throws \Exception
     */
    public function clean();

    /**
     * @param array $arguments
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $arguments);

    /**
     * @return bool
     */
    public function hasScript();

    /**
     * @return FSOFileInterface
     * @throws \Exception
     */
    public function getScript();

    /**
     * @param FSOFileInterface|null $script
     * @return static
     * @throws \Exception
     */
    public function setScript(FSOFileInterface $script = null);

    /**
     * @return bool
     */
    public function hasCommand();

    /**
     * @return string
     */
    public function getCommand();

    /**
     * @param string $command
     * @return static
     * @throws \Exception
     */
    public function setCommand(string $command);

    /**
     * @return static
     * @throws \Exception
     */
    public function setCommandToDefault();
}