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
namespace GI\Component\Menu;

use GI\Component\Base\ComponentInterface;

interface MenuInterface extends ComponentInterface
{
    /**
     * @return bool
     */
    public function isBar();

    /**
     * @return bool
     */
    public function isContext();

    /**
     * @return string
     * @throws \Exception
     */
    public function toString();

    /**
     * @param ComponentInterface $component
     * @return static
     * @throws \Exception
     */
    public function setBeforeSelectRelation(ComponentInterface $component);

    /**
     * @param ComponentInterface $component
     * @return static
     * @throws \Exception
     */
    public function setAfterSelectRelation(ComponentInterface $component);

    /**
     * @param ComponentInterface $component
     * @return static
     * @throws \Exception
     */
    public function setBeforeUnselectRelation(ComponentInterface $component);

    /**
     * @param ComponentInterface $component
     * @return static
     * @throws \Exception
     */
    public function setAfterUnselectRelation(ComponentInterface $component);

    /**
     * @param ComponentInterface $component
     * @return static
     * @throws \Exception
     */
    public function setOnClickRelation(ComponentInterface $component);
}