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
namespace GI\Debugging\Tracing\ArgumentList;

use GI\Debugging\Tracing\Argument\Argument;
use GI\Debugging\Tracing\ArgumentList\View\View;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Debugging\Tracing\Argument\ArgumentInterface;
use GI\Debugging\Tracing\ArgumentList\View\ViewInterface;

class ArgumentList implements ArgumentListInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ArgumentInterface[]
     */
    private $items = [];

    /**
     * @var ViewInterface
     */
    private $view;


    /**
     * ArgumentList constructor.
     * @param array $values
     * @throws \Exception
     */
    public function __construct(array $values = [])
    {
        $f = function($value)
        {
            return $this->createItem($value);
        };
        $this->items = array_map($f, $values);

        $this->view = $this->giGetDi(ViewInterface::class, View::class);
    }

    /**
     * @param mixed $value
     * @return ArgumentInterface
     * @throws \Exception
     */
    protected function createItem($value)
    {
        try {
            $result = $this->giGetDi(ArgumentInterface::class, null, [$value]);
        } catch (\Exception $exception) {
            $result = new Argument($value);
        }

        return $result;
    }

    /**
     * @return ArgumentInterface[]
     */
    protected function getItems()
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
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
        return $this->getView()->setItems($this->getItems())->toString();
    }
}