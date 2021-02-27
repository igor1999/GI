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
namespace GI\Component\Menu\View\Builder\Container;

use GI\Component\Menu\View\Builder\Menu\Menu;
use GI\Component\Menu\View\Builder\Option\Option;
use GI\Component\Menu\View\Builder\Option\Content\Content as OptionContent;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Component\Menu\View\WidgetInterface;
use GI\Component\Menu\View\Builder\Menu\MenuInterface;
use GI\Component\Menu\View\Builder\Option\OptionInterface;
use GI\Component\Menu\View\Builder\Option\Content\ContentInterface as OptionContentInterface;

class Container implements ContainerInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var MenuInterface
     */
    private $menuBuilder;

    /**
     * @var OptionInterface
     */
    private $optionBuilder;

    /**
     * @var OptionContentInterface
     */
    private $optionContentBuilder;


    /**
     * Container constructor.
     * @param WidgetInterface $widget
     * @throws \Exception
     */
    public function __construct(WidgetInterface $widget)
    {
        $this->menuBuilder = $this->giGetDi(MenuInterface::class, Menu::class);

        $this->optionBuilder = $this->giGetDi(OptionInterface::class, new Option($widget), [$widget]);

        $this->optionContentBuilder = $this->giGetDi(
            OptionContentInterface::class, new OptionContent($widget), [$widget]
        );
    }

    /**
     * @return MenuInterface
     */
    public function getMenuBuilder()
    {
        return $this->menuBuilder;
    }

    /**
     * @return OptionInterface
     */
    public function getOptionBuilder()
    {
        return $this->optionBuilder;
    }

    /**
     * @return OptionContentInterface
     */
    public function getOptionContentBuilder()
    {
        return $this->optionContentBuilder;
    }
}