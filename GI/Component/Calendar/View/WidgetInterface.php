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
namespace GI\Component\Calendar\View;

use GI\Component\Base\View\Widget\WidgetInterface as BaseInterface;
use GI\Component\Calendar\ViewModel\ViewModelInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Form\Layouts\Form\FormInterface as FormLayoutInterface;
use GI\DOM\HTML\Element\Input\Button\ButtonInterface;
use GI\DOM\HTML\Element\Input\DateTime\MonthInterface;
use GI\DOM\HTML\Element\Table\Row\TRInterface;
use GI\DOM\HTML\Element\Table\TableInterface;

/**
 * Interface WidgetInterface
 * @package GI\Component\Calendar\View
 *
 * @method ViewModelInterface getViewModel()
 * @method WidgetInterface setViewModel(ViewModelInterface $viewModel)
 */
interface WidgetInterface extends BaseInterface
{
    /**
     * @return DivInterface
     */
    public function getContainer();

    /**
     * @return FormLayoutInterface
     */
    public function getNavigationForm();

    /**
     * @return MonthInterface
     */
    public function getNavigationMonth();

    /**
     * @return ButtonInterface
     */
    public function getNavigationSubmitButton();

    /**
     * @return TableInterface
     */
    public function getContentTable();

    /**
     * @return TRInterface
     */
    public function getContentHeadRow();
}