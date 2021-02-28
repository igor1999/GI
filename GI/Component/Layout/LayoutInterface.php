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
namespace GI\Component\Layout;

use GI\Component\Base\ComponentInterface;
use GI\Component\Authentication\AuthenticationInterface;
use GI\Component\BreadCrumbs\Base\BreadCrumbsInterface;
use GI\Component\Layout\View\ViewInterface;
use GI\Component\Menu\MenuInterface;

interface LayoutInterface extends ComponentInterface
{
    /**
     * @return ViewInterface
     */
    public function getView();

    /**
     * @return AuthenticationInterface
     * @throws \Exception
     */
    public function getAuthentication();

    /**
     * @return BreadCrumbsInterface
     * @throws \Exception
     */
    public function getNaviBreadCrumbs();

    /**
     * @return MenuInterface
     * @throws \Exception
     */
    public function getNaviMenu();

    /**
     * @return ComponentInterface
     * @throws \Exception
     */
    public function getContent();

    /**
     * @param string $message
     * @return static
     */
    public function createAccessDenied(string $message);

    /**
     * @param string $message
     * @return static
     */
    public function createNotFound(string $message);

    /**
     * @param string $message
     * @return static
     */
    public function createServerError(string $message);

    /**
     * @return string
     * @throws \Exception
     */
    public function toString();
}