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
namespace GI\Component\Authentication\Login\View\Widget;

use GI\Component\Base\View\Widget\WidgetInterface as BaseInterface;
use GI\Component\Authentication\Login\Dialog\DialogInterface;
use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;

/**
 * Interface WidgetInterface
 * @package GI\Component\Authentication\Login\View\Widget
 *
 * @method string getRegisterURI()
 * @method WidgetInterface setRegisterURI(string $registerURI)
 * @method string getRestorePasswordURI()
 * @method WidgetInterface setRestorePasswordURI(string $restorePasswordURI)
 */
interface WidgetInterface extends BaseInterface
{
    /**
     * @param DialogInterface $dialog
     * @return static
     * @throws \Exception
     */
    public function addDialogRelation(DialogInterface $dialog);

    /**
     * @return LayoutInterface
     */
    public function getContainer();

    /**
     * @return HyperlinkInterface
     */
    public function getLoginLink();

    /**
     * @return HyperlinkInterface
     */
    public function getRegisterLink();

    /**
     * @return HyperlinkInterface
     */
    public function getRestorePasswordLink();
}