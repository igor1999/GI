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

use GI\Component\Authentication\Login\Dialog\ViewModel\ViewModelInterface;
use GI\DOM\HTML\Element\Form\Layouts\Form\FormInterface as FormLayoutInterface;
use GI\DOM\HTML\Element\Input\Text\TextInterface;
use GI\DOM\HTML\Element\Input\Text\PasswordInterface;
use GI\DOM\HTML\Element\Input\Logical\CheckboxInterface;
use GI\DOM\HTML\Element\TextContainer\Label\LabelInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Input\Button\SubmitInterface;

trait ContentsTrait
{
    /**
     * @var FormLayoutInterface
     */
    private $form;

    /**
     * @var TextInterface
     */
    private $loginTextbox;

    /**
     * @var PasswordInterface
     */
    private $passwordTextbox;

    /**
     * @var CheckboxInterface
     */
    private $saveCheckbox;

    /**
     * @var LabelInterface
     */
    private $saveLabel;

    /**
     * @var SubmitInterface
     */
    private $submitButton;

    /**
     * @var DivInterface
     */
    private $resultMessageContainer;


    /**
     * @validate
     * @throws \Exception
     */
    protected function validateViewModel()
    {
        if (!($this->getViewModel() instanceof ViewModelInterface)) {
            $this->giThrowInvalidTypeException('View model', '', 'ViewModelInterface');
        }
    }

    /**
     * @return FormLayoutInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return TextInterface
     */
    public function getLoginTextbox()
    {
        return $this->loginTextbox;
    }

    /**
     * @return PasswordInterface
     */
    public function getPasswordTextbox()
    {
        return $this->passwordTextbox;
    }

    /**
     * @return CheckboxInterface
     */
    public function getSaveCheckbox()
    {
        return $this->saveCheckbox;
    }

    /**
     * @return LabelInterface
     */
    public function getSaveLabel()
    {
        return $this->saveLabel;
    }

    /**
     * @return SubmitInterface
     */
    public function getSubmitButton()
    {
        return $this->submitButton;
    }

    /**
     * @return DivInterface
     */
    public function getResultMessageContainer()
    {
        return $this->resultMessageContainer;
    }
}