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
namespace GI\Debugging\Tracing\Tracing;

use GI\Debugging\Tracing\Option\Option;
use GI\Debugging\Tracing\Tracing\View\View;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Debugging\Tracing\Option\OptionInterface;
use GI\Debugging\Tracing\Tracing\View\ViewInterface;

class Tracing implements TracingInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var OptionInterface[]
     */
    private $options = [];

    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * Tracing constructor.
     * @param array $contents
     * @throws \Exception
     */
    public function __construct(array $contents = [])
    {
        if (empty($contents)) {
            $contents = debug_backtrace();
        }

        $f = function($item)
        {
            return $this->createOption($item);
        };
        $this->options = array_map($f, $contents);

        $f = function(OptionInterface $option)
        {
            return !$option->toRemove();
        };
        $this->options = array_values(array_filter($this->options, $f));

        $this->view = $this->giGetDi(ViewInterface::class, View::class);
    }

    /**
     * @param array $contents
     * @return OptionInterface
     * @throws \Exception
     */
    protected function createOption(array $contents)
    {
        try {
            $result = $this->giGetDi(OptionInterface::class, null, [$contents]);
        } catch (\Exception $exception) {
            $result = new Option($contents);
        }

        return $result;
    }

    /**
     * @return OptionInterface[]
     */
    protected function getOptions()
    {
        return $this->options;
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
        return $this->getView()->setOptions($this->getOptions())->toString();
    }
}