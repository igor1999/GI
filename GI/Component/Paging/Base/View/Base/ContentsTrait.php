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
namespace GI\Component\Paging\Base\View\Base;

use GI\DOM\HTML\Element\Form\FormInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Select\SelectInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Div\DivInterface;

trait ContentsTrait
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var LayoutInterface
     */
    private $container;

    /**
     * @var SelectInterface
     */
    private $sizesSelect;

    /**
     * @var HiddenInterface
     */
    private $selectedPageHidden;

    /**
     * @var DivInterface
     */
    private $naviToFirst;

    /**
     * @var DivInterface
     */
    private $naviToPrev;

    /**
     * @var DivInterface
     */
    private $naviToNext;

    /**
     * @var DivInterface
     */
    private $naviToLast;
}