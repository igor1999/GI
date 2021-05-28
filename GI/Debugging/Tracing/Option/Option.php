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
namespace GI\Debugging\Tracing\Option;

use GI\Debugging\Tracing\ArgumentList\ArgumentList;
use GI\Debugging\Tracing\Option\View\View;

use GI\ServiceLocator\ServiceLocator;
use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\HydrationTrait;

use GI\Debugging\Tracing\ArgumentList\ArgumentListInterface;
use GI\Debugging\Tracing\Option\View\ViewInterface;

class Option implements OptionInterface
{
    use ServiceLocatorAwareTrait, HydrationTrait;


    const METHOD_TEMPLATE = '%s::%s';


    const SERVICE_LOCATOR_CLOSURE_REG_EXP = '/\\\{closure}$/';


    const DEBUGGING_NAMESPACE    = 'GI\\Debugging\\';

    const TRIGGER_ERROR_FUNCTION = 'trigger_error';


    /**
     * @var string
     */
    private $class = '';

    /**
     * @var string
     */
    private $function = '';

    /**
     * @var string
     */
    private $file = '';

    /**
     * @var int
     */
    private $line = 0;

    /**
     * @var ArgumentListInterface
     */
    private $arguments;

    /**
     * @var ViewInterface
     */
    private $view;


    /**
     * Option constructor.
     * @param array $contents
     * @throws \Exception
     */
    public function __construct(array $contents)
    {
        $this->arguments = $this->createArguments();

        $this->hydrate($contents);

        $this->view = $this->getGiServiceLocator()->getDependency(ViewInterface::class, View::class);
    }

    /**
     * @return bool
     */
    public function toRemove()
    {
        $inServiceLocator = ($this->class === ServiceLocator::class);
        $closure = preg_match(static::SERVICE_LOCATOR_CLOSURE_REG_EXP, $this->function);

        $serviceLocatorClosure = $inServiceLocator && $closure;

        return $serviceLocatorClosure
            || (strpos($this->class, static::DEBUGGING_NAMESPACE) === 0)
            || ($this->function == static::TRIGGER_ERROR_FUNCTION);
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }

    /**
     * @hydrate
     * @param string $class
     * @return static
     */
    protected function setClass(string $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFunction()
    {
        return $this->function;
    }

    /**
     * @hydrate
     * @param string $function
     * @return static
     */
    protected function setFunction(string $function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFile()
    {
        return $this->file;
    }

    /**
     * @hydrate
     * @param string $file
     * @return static
     */
    protected function setFile(string $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return int
     */
    protected function getLine()
    {
        return $this->line;
    }

    /**
     * @hydrate
     * @param int $line
     * @return static
     */
    protected function setLine(int $line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * @return ArgumentListInterface
     */
    protected function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @hydrate args
     * @param array $arguments
     * @return static
     * @throws \Exception
     */
    protected function setArguments(array $arguments)
    {
        $this->arguments = $this->createArguments($arguments);

        return $this;
    }

    /**
     * @param array $arguments
     * @return ArgumentListInterface
     * @throws \Exception
     */
    protected function createArguments(array $arguments = [])
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(ArgumentListInterface::class, null, [$arguments]);
        } catch (\Exception $exception) {
            $result = new ArgumentList($arguments);
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function createMethod()
    {
        return empty($this->class) ? $this->function : sprintf(static::METHOD_TEMPLATE, $this->class, $this->function);
    }

    /**
     * @return ViewInterface
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getView()
            ->setMethod($this->createMethod())
            ->setFile($this->file)
            ->setLine($this->line)
            ->setArguments($this->getArguments())
            ->toString();
    }
}