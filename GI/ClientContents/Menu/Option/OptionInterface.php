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
namespace GI\ClientContents\Menu\Option;

use GI\ClientContents\NavigationNode\NavigationNodeInterface;
use GI\ClientContents\Menu\MenuInterface;

interface OptionInterface extends  NavigationNodeInterface
{
    /**
     * @return bool
     */
    public function hasContainer();

    /**
     * @return MenuInterface
     * @throws \Exception
     */
    public function getContainer();

    /**
     * @return string
     */
    public function getLocalID();

    /**
     * @return string
     */
    public function getGlobalID();

    /**
     * @return bool
     */
    public function hasPopup();

    /**
     * @return MenuInterface
     * @throws \Exception
     */
    public function getPopup();

    /**
     * @param MenuInterface $popup
     * @return static
     * @throws \Exception
     */
    public function setPopup(MenuInterface $popup);

    /**
     * @return bool
     */
    public function isDisabled();

    /**
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(bool $disabled);

    /**
     * @return bool
     */
    public function isHidden();

    /**
     * @param bool $hidden
     * @return static
     */
    public function setHidden(bool $hidden);

    /**
     * @return bool
     */
    public function isSelected();

    /**
     * @param bool $selected
     * @return static
     */
    public function setSelected(bool $selected);

    /**
     * @param bool $selected
     * @return static
     */
    public function selectRecursive(bool $selected);
}