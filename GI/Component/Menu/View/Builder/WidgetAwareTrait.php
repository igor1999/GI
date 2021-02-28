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
namespace GI\Component\Menu\View\Builder;

use GI\Component\Menu\View\WidgetInterface;

trait WidgetAwareTrait
{
    /**
     * @var WidgetInterface
     */
    private $widget;


    /**
     * @return WidgetInterface
     */
    protected function getWidget()
    {
        return $this->widget;
    }

    /**
     * @param WidgetInterface $widget
     * @return static
     */
    protected function setWidget(WidgetInterface $widget)
    {
        $this->widget = $widget;

        return $this;
    }

    /**
     * @param int $level
     * @return bool
     */
    protected function isMenuBar(int $level)
    {
        return $level == 0 && $this->widget->isBar();
    }
}