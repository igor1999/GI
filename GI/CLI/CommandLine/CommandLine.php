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

use GI\CLI\CommandLine\Execution\Execution;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Closing\ClosingTrait;

use GI\CLI\CommandLine\Argument\ArgumentInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\CLI\CommandLine\Context\ContextInterface;
use GI\CLI\CommandLine\Execution\ExecutionInterface;

class CommandLine implements CommandLineInterface
{
    use ServiceLocatorAwareTrait, ClosingTrait;


    const DEFAULT_COMMAND = 'php.exe';


    const ROUTE_ARGUMENT_NAME   = 'route';

    const SESSION_ARGUMENT_NAME = 'session';

    const DEMON_ARGUMENT_NAME   = 'demon';

    const JOB_ARGUMENT_NAME     = 'job';


    /**
     * @var ArgumentInterface[]
     */
    private $items = [];

    /**
     * @var FSOFileInterface
     */
    private $script;

    /**
     * @var string
     */
    private $command = '';

    /**
     * @var ExecutionInterface
     */
    private $executionProcessor;


    /**
     * CommandLine constructor.
     * @param array $items
     * @param FSOFileInterface|null $script
     * @param string $command
     * @throws \Exception
     */
    public function __construct(array $items = [], FSOFileInterface $script = null, string $command = '')
    {
        $this->executionProcessor = $this->giGetDi(ExecutionInterface::class, Execution::class, [$this]);

        foreach ($items as $item) {
            $this->add($item);
        }

        if (empty($script)) {
            try {
                $context = $this->createContext();
                $this->setScript($context->getScript());
            } catch (\Exception $exception) {}
        } else {
            $this->setScript($script);
        }

        if (empty($command)) {
            try {
                $context = $this->createContext();
                $this->setCommand($context->getCommand());
            } catch (\Exception $exception) {
                $this->setCommandToDefault();
            }
        } else {
            $this->setCommand($command);
        }
    }

    /**
     * @return ExecutionInterface
     */
    public function getExecutionProcessor()
    {
        return $this->executionProcessor;
    }

    /**
     * @return ContextInterface
     * @throws \Exception
     */
    protected function createContext()
    {
        /** @var ContextInterface $context */
        $context = $this->giGetDi(ContextInterface::class);

        return $context;
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->setClosed(true);

        foreach ($this->items as $item) {
            $item->close();
        }

        return $this;
    }

    /**
     * @param int $position
     * @return bool
     */
    public function has(int $position)
    {
        return isset($this->items[$position]);
    }

    /**
     * @param int $position
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function get(int $position)
    {
        if (!$this->has($position)) {
            $this->giThrowNotInScopeException($position);
        }

        return $this->items[$position];
    }

    /**
     * @param int $position
     * @param mixed $default
     * @return string
     */
    public function getValueOptional(int $position, $default = '')
    {
        try {
            $result = $this->get($position)->getValue();
        } catch (\Exception $e) {
            $result = $default;
        }

        return $result;
    }

    /**
     * @return ArgumentInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param \Closure $filter
     * @param bool $withScript
     * @param bool $withCommand
     * @return static
     * @throws \Exception
     */
    public function filter(\Closure $filter, bool $withScript = false, bool $withCommand = false)
    {
        return new static(
            array_filter($this->items, $filter),
            $withScript ? $this->getScript() : null,
            $withCommand ? $this->getCommand() : ''
        );
    }

    /**
     * @param string $raw
     * @param bool $withScript
     * @param bool $withCommand
     * @return static
     * @throws \Exception
     */
    public function filterRaws(string $raw, bool $withScript = false, bool $withCommand = false)
    {
        $f = function(ArgumentInterface $item) use ($raw)
        {
            return $item->toString() == $raw;
        };

        return $this->filter($f, $withScript, $withCommand);
    }

    /**
     * @param string $name
     * @param bool $withScript
     * @param bool $withCommand
     * @return static
     * @throws \Exception
     */
    public function filterNames(string $name, bool $withScript = false, bool $withCommand = false)
    {
        $f = function(ArgumentInterface $item) use ($name)
        {
            return $item->getName() == $name;
        };

        return $this->filter($f, $withScript, $withCommand);
    }

    /**
     * @param string $value
     * @param bool $withScript
     * @param bool $withCommand
     * @return static
     * @throws \Exception
     */
    public function filterValues(string $value, bool $withScript = false, bool $withCommand = false)
    {
        $f = function(ArgumentInterface $item) use ($value)
        {
            return $item->getValue() == $value;
        };

        return $this->filter($f, $withScript, $withCommand);
    }

    /**
     * @param string $name
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function findByName(string $name)
    {
        $items = $this->filterNames($name);

        if ($items->isEmpty()) {
            $this->giThrowNotFoundException('CLI argument', $name);
        }

        return $items->get(0);
    }

    /**
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public function findValueByName(string $name)
    {
        return $this->findByName($name)->getValue();
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return string
     */
    public function findValueByNameOptional(string $name, $default = '')
    {
        try {
            $value = $this->findValueByName($name);
        } catch (\Exception $e) {
            $value = $default;
        }

        return $value;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getRoute()
    {
        return $this->findValueByName(static::ROUTE_ARGUMENT_NAME);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getSession()
    {
        return $this->findValueByName(static::SESSION_ARGUMENT_NAME);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDemon()
    {
        return $this->findValueByName(static::DEMON_ARGUMENT_NAME);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getJob()
    {
        return $this->findValueByName(static::JOB_ARGUMENT_NAME);
    }

    /**
     * @param bool $base64
     * @return static
     */
    public function setBase64(bool $base64)
    {
        foreach ($this->items as $item) {
            $item->setBase64($base64);
        }

        return $this;
    }

    /**
     * @param string $raw
     * @return ArgumentInterface
     */
    protected function createItem(string $raw = '')
    {
        return $this->giGetCLIFactory()->createArgumentsItem($raw);
    }

    /**
     * @param ArgumentInterface $item
     * @return static
     * @throws \Exception
     */
    public function add(ArgumentInterface $item)
    {
        $this->validateClosing();

        $this->items[] = $item;

        return $this;
    }

    /**
     * @param string $raw
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function createAndAdd(string $raw = '')
    {
        $item = $this->createItem($raw);
        $this->add($item);

        return $item;
    }

    /**
     * @param string $name
     * @param string $value
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function createAndAddNamed(string $name, string $value, bool $base64 = false)
    {
        $this->createAndAdd()->setName($name)->setValue($value)->setBase64($base64);

        return $this;
    }

    /**
     * @param int $position
     * @param ArgumentInterface $item
     * @return static
     * @throws \Exception
     */
    public function insert(int $position, ArgumentInterface $item)
    {
        $this->validateClosing();

        if ($this->has($position)) {
            array_splice($this->items, $position, 0, [$item]);
        } else {
            $this->add($item);
        }

        return $this;
    }

    /**
     * @param int $position
     * @param string $raw
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function createAndInsert(int $position, string $raw = '')
    {
        $item = $this->createItem($raw);
        $this->insert($position, $item);

        return $item;
    }

    /**
     * @param int $position
     * @param string $name
     * @param string $value
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function createAndInsertNamed(int $position, string $name, string $value, bool $base64 = false)
    {
        $this->createAndInsert($position)->setName($name)->setValue($value)->setBase64($base64);

        return $this;
    }

    /**
     * @param int $position
     * @param ArgumentInterface $item
     * @return static
     * @throws \Exception
     */
    public function set(int $position, ArgumentInterface $item)
    {
        $this->validateClosing();

        $this->get($position);
        $this->items = $item;

        return $this;
    }

    /**
     * @param int $position
     * @param string $raw
     * @return ArgumentInterface
     * @throws \Exception
     */
    public function createAndSet(int $position, string $raw = '')
    {
        $item = $this->createItem($raw);
        $this->set($position, $item);

        return $item;
    }

    /**
     * @param int $position
     * @param string $name
     * @param string $value
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function createAndSetNamed(int $position, string $name, string $value, bool $base64 = false)
    {
        $this->createAndSet($position)->setName($name)->setValue($value)->setBase64($base64);

        return $this;
    }

    /**
     * @param string $route
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addRoute(string $route, bool $base64 = false)
    {
        $this->createAndAddNamed(static::ROUTE_ARGUMENT_NAME, $route, $base64);

        return $this;
    }

    /**
     * @param string $sessionID
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addSession(string $sessionID, bool $base64 = false)
    {
        $this->createAndAddNamed(static::SESSION_ARGUMENT_NAME, $sessionID, $base64);

        return $this;
    }

    /**
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addCurrentSession(bool $base64 = false)
    {
        $this->addSession($this->giGetServiceLocator()->getSessionID(), $base64);

        return $this;
    }

    /**
     * @param string $demon
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addDemon(string $demon, bool $base64 = false)
    {
        $this->createAndAddNamed(static::DEMON_ARGUMENT_NAME, $demon, $base64);

        return $this;
    }

    /**
     * @param string $job
     * @param bool $base64
     * @return static
     * @throws \Exception
     */
    public function addJob(string $job, bool $base64 = false)
    {
        $this->createAndAddNamed(static::JOB_ARGUMENT_NAME, $job, $base64);

        return $this;
    }

    /**
     * @param int $position
     * @return bool
     * @throws \Exception
     */
    public function remove(int $position)
    {
        $this->validateClosing();

        if ($result = $this->has($position)) {
            array_splice($this->items, $position, 1);
        }

        return $result;
    }

    /**
     * @param string $name
     * @return static
     * @throws \Exception
     */
    public function removeByName(string $name)
    {
        $f = function(ArgumentInterface $item) use ($name)
        {
            return $item->getName() == $name;
        };

        $keys = array_reverse(array_keys(array_filter($this->items, $f)));

        foreach ($keys as $key) {
            $this->remove($key);
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function removeRoute()
    {
        $this->removeByName(static::ROUTE_ARGUMENT_NAME);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function removeSession()
    {
        $this->removeByName(static::SESSION_ARGUMENT_NAME);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function removeDemon()
    {
        $this->removeByName(static::DEMON_ARGUMENT_NAME);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function removeJob()
    {
        $this->removeByName(static::JOB_ARGUMENT_NAME);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function clean()
    {
        $this->validateClosing();

        $this->items = [];

        return $this;
    }

    /**
     * @param array $arguments
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $arguments)
    {
        $this->validateClosing();

        if (!empty($arguments)) {
            $path = array_shift($arguments);
            $file = $this->giCreateFSOFile($path);
            $this->setScript($file);
        }

        $this->clean();

        foreach (array_values($arguments) as $position => $raw) {
            $this->createAndAdd($raw);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function extract()
    {
        $result = [];

        foreach ($this->getItems() as $position => $item) {
            if ($item->isNamed()) {
                $result[$item->getName()] = $item->getValue();
            } else {
                $result[$position] = $item->getValue();
            }
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function hasScript()
    {
        return $this->script instanceof FSOFileInterface;
    }

    /**
     * @return FSOFileInterface
     * @throws \Exception
     */
    public function getScript()
    {
        if (!$this->hasScript()) {
            $this->giThrowNotSetException('CLI Script');
        }

        return $this->script;
    }

    /**
     * @param FSOFileInterface|null $script
     * @return static
     * @throws \Exception
     */
    public function setScript(FSOFileInterface $script = null)
    {
        $this->validateClosing();

        $this->script = $script;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasCommand()
    {
        return !empty($this->command);
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $command
     * @return static
     * @throws \Exception
     */
    public function setCommand(string $command)
    {
        $this->validateClosing();

        $this->command = $command;

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setCommandToDefault()
    {
        $this->setCommand(static::DEFAULT_COMMAND);

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $f = function(ArgumentInterface $item)
        {
            return escapeshellarg($item->toString());
        };

        $result = implode(self::SEPARATOR, array_map($f, $this->items));

        try {
            $result = $this->getScript()->getPath() . self::SEPARATOR . $result;
        } catch (\Exception $e) {}

        if ($this->hasCommand()) {
            $result = $this->getCommand() . self::SEPARATOR . $result;
        }

        return $result;
    }
}