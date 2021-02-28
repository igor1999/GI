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
namespace GI\Component\Layout\View;

use GI\Component\Base\View\ViewInterface as BaseInterface;
use GI\Component\Authentication\AuthenticationInterface;
use GI\Component\BreadCrumbs\Base\BreadCrumbsInterface;
use GI\Component\Menu\MenuInterface;
use GI\Component\Base\ComponentInterface;

/**
 * Interface ViewInterface
 * @package GI\Component\Layout\View
 *
 * @method string getTitle()
 * @method ViewInterface setTitle(string $title)
 * @method AuthenticationInterface getAuthentication()
 * @method ViewInterface setAuthentication(AuthenticationInterface $authentication)
 * @method BreadCrumbsInterface getNaviBreadCrumbs()
 * @method ViewInterface setNaviBreadCrumbs(BreadCrumbsInterface $breadCrumbs)
 * @method MenuInterface getNaviMenu()
 * @method ViewInterface setNaviMenu(MenuInterface $menu)
 * @method ComponentInterface getContent()
 * @method ViewInterface setContent(ComponentInterface $component)
 */
interface ViewInterface extends BaseInterface
{

}