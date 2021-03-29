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
namespace GI\Component\Authentication\Login\Dialog\View;

use GI\Component\Dialog\View\WidgetInterface as BaseInterface;
use GI\Component\Authentication\Login\Dialog\ViewModel\ViewModelInterface;
use GI\DOM\HTML\Element\Form\Layouts\Form\FormInterface as FormLayoutInterface;
use GI\DOM\HTML\Element\Input\Text\TextInterface;
use GI\DOM\HTML\Element\Input\Text\PasswordInterface;
use GI\DOM\HTML\Element\Input\Logical\CheckboxInterface;
use GI\DOM\HTML\Element\TextContainer\Label\LabelInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Input\Button\SubmitInterface;

/**
 * Interface WidgetInterface
 * @package GI\Component\Authentication\Login\Dialog\View
 *
 * @method ViewModelInterface getViewModel()
 * @method WidgetInterface setViewModel(ViewModelInterface $viewModel)
 * @method bool isHasCookie()
 * @method WidgetInterface setHasCookie(bool $hasCookie)
 * @method string getLoginCheckAction()
 * @method WidgetInterface setLoginCheckAction(string $loginCheckAction)
 */
interface WidgetInterface extends BaseInterface
{
    /**
     * @return FormLayoutInterface
     */
    public function getForm();

    /**
     * @return TextInterface
     */
    public function getLoginTextbox();

    /**
     * @return PasswordInterface
     */
    public function getPasswordTextbox();

    /**
     * @return CheckboxInterface
     */
    public function getSaveCheckbox();

    /**
     * @return LabelInterface
     */
    public function getSaveLabel();

    /**
     * @return SubmitInterface
     */
    public function getSubmitButton();

    /**
     * @return DivInterface
     */
    public function getResultMessageContainer();
}