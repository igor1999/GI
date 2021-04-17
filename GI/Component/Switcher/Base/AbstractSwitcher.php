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
namespace GI\Component\Switcher\Base;

use GI\ClientContents\Selection\Single\SingleInterface as SelectionInterface;
use GI\Component\Base\AbstractComponent;
use GI\Component\Switcher\Base\View\Widget;

use GI\Component\Switcher\Base\View\WidgetInterface;

abstract class AbstractSwitcher extends AbstractComponent implements SwitcherInterface
{
    /**
     * @var WidgetInterface
     */
    private $view;

    /**
     * @var array
     */
    private $name;


    /**
     * AbstractSwitcher constructor.
     * @param array $name
     * @throws \Exception
     */
    public function __construct(array $name = [])
    {
        $this->name  = $name;

        $this->view = $this->giGetDi(WidgetInterface::class, Widget::class);
    }

    /**
     * @return SelectionInterface
     */
    abstract protected function getSelection();

    /**
     * @return WidgetInterface
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return array
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getView()->setName($this->name)->setSelection($this->getSelection())->toString();
    }
}