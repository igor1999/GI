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
namespace GI\Component\Menu\View\Builder\Menu;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Component\Menu\View\Builder\WidgetAwareTrait;

use GI\DOM\HTML\Element\Lists\UL\ULInterface;

class Menu implements MenuInterface
{
    use ServiceLocatorAwareTrait, WidgetAwareTrait;


    const SUBMENU_ATTRIBUTE  = 'submenu';


    /**
     * @param string $id
     * @return ULInterface
     * @throws \Exception
     */
    public function buildMenu(string $id)
    {
        $menu = $this->getGiServiceLocator()->getDOMFactory()->createUL();

        $menu->getAttributes()->setDataAttribute(static::SUBMENU_ATTRIBUTE, $id);
        $menu->getStyle()->setPadding(0)->setMargin(0);

        if ($this->getWidget()->isContext()) {
            $menu->getStyle()->setPositionToAbsolute()->setDisplayToNone();
        }

        return $menu;
    }

    /**
     * @param string $id
     * @return ULInterface
     * @throws \Exception
     */
    public function buildPopupMenu(string $id)
    {
        $menu = $this->buildMenu($id);

        $menu->getStyle()->setDisplayToNone()->setPositionToAbsolute();

        return $menu;
    }
}