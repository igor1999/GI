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
namespace GI\Component\Switcher\OnOff;

use GI\Component\Switcher\Base\AbstractSwitcher;
use GI\Component\Switcher\OnOff\View\Widget;

use GI\ClientContents\Selection\Advanced\OnOff\OnOffInterface as SelectionInterface;
use GI\Component\Switcher\OnOff\View\WidgetInterface;

class OnOff extends AbstractSwitcher implements OnOffInterface
{
    /**
     * @var SelectionInterface
     */
    private $selection;

    /**
     * @var WidgetInterface
     */
    private $view;


    /**
     * OnOff constructor.
     * @param array $name
     * @throws \Exception
     */
    public function __construct(array $name = [])
    {
        parent::__construct($name);

        $this->selection = $this->getGiServiceLocator()->getClientSelectionFactory()->createOnOff();

        $this->view = $this->getGiServiceLocator()->getDependency(WidgetInterface::class, Widget::class);
    }

    /**
     * @return SelectionInterface
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * @return WidgetInterface
     */
    protected function getView()
    {
        return $this->view;
    }
}