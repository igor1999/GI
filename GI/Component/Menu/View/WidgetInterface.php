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
namespace GI\Component\Menu\View;

use GI\Component\Base\View\Widget\WidgetInterface as BaseInterface;
use GI\ClientContents\Menu\MenuInterface as ModelInterface;
use GI\Component\Base\ComponentInterface;

/**
 * Interface WidgetInterface
 * @package GI\Component\Menu\View
 *
 * @method ModelInterface getModel()
 * @method WidgetInterface setModel(ModelInterface $model)
 * @method bool isBar()
 * @method WidgetInterface setBar(bool $bar)
 * @method bool isContext()
 * @method WidgetInterface setContext(bool $context)
 */
interface WidgetInterface extends BaseInterface
{
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
    public function setBeforeClickRelation(ComponentInterface $component);

    /**
     * @param ComponentInterface $component
     * @return static
     * @throws \Exception
     */
    public function setAfterClickRelation(ComponentInterface $component);
}