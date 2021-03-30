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
namespace GI\Component\Authentication\Logout\View;

use GI\Component\Base\View\Widget\WidgetInterface as BaseInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;
use GI\DOM\HTML\Element\TextContainer\Span\SpanInterface;

/**
 * Interface WidgetInterface
 * @package GI\Component\Authentication\Logout\View
 *
 * @method getSalutation()
 * @method WidgetInterface setSalutation($salutation)
 * @method string getLogoutAction()
 * @method WidgetInterface setLogoutAction(string $logoutAction)
 */
interface WidgetInterface extends BaseInterface
{
    /**
     * @return LayoutInterface
     */
    public function getContainer();

    /**
     * @return SpanInterface
     */
    public function getSalutationSpan();

    /**
     * @return HyperlinkInterface
     */
    public function getLogoutLink();
}