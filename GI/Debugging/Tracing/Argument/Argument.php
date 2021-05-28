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
namespace GI\Debugging\Tracing\Argument;

use GI\Debugging\Tracing\Argument\View\View;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Debugging\Tracing\Argument\View\ViewInterface;

class Argument implements ArgumentInterface
{
    use ServiceLocatorAwareTrait;


    const ARRAY_TITLE           = 'Array';

    const OBJECT_TITLE_TEMPLATE = 'Object of %s';


    /**
     * @var mixed
     */
    private $value;

    /**
     * @var ViewInterface
     */
    private $view;


    /**
     * Argument constructor.
     * @param mixed $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        $this->value = $value;

        $this->view = $this->getGiServiceLocator()->getDependency(ViewInterface::class, View::class);
    }

    /**
     * @return mixed
     */
    protected function getValue()
    {
        return $this->value;
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
     */
    protected function getTitle()
    {
        if (is_array($this->value)) {
            $title = static::ARRAY_TITLE;
        } elseif (is_object($this->value)) {
            $title = sprintf(static::OBJECT_TITLE_TEMPLATE, get_class($this->value));
        } else {
            $title = '';
        }

        return $title;
    }

    /**
     * @return string
     */
    protected function getContents()
    {
        ob_start();

        var_dump($this->value);

        return ob_get_clean();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getView()->setTitle($this->getTitle())->setContents($this->getContents())->toString();
    }
}