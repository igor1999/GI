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
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Lists\UL\ULInterface;

/**
 * Interface WidgetInterface
 * @package GI\Component\Menu\View
 *
 * @method ModelInterface getModel()
 * @method WidgetInterface setModel(ModelInterface $model)
 * @method bool isBar()
 * @method WidgetInterface setBar(bool $bar)
 */
interface WidgetInterface extends BaseInterface
{
    /**
     * @return ULInterface
     */
    public function getTopMenu();

    /**
     * @return DivInterface[][]
     */
    public function getOptions();

    /**
     * @param string $containerID
     * @param string $localID
     * @return DivInterface
     * @throws \Exception
     */
    public function getOption(string $containerID, string $localID);

    /**
     * @return ULInterface[]
     */
    public function getPopups();

    /**
     * @param string $id
     * @return ULInterface
     * @throws \Exception
     */
    public function getPopup(string $id);
}