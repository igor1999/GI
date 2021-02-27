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

use GI\Component\Calendar\ViewModel\ViewModelInterface;
use GI\DOM\HTML\Element\Table\Row\TRInterface;
use GI\DOM\HTML\Element\Table\TableInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Form\Layouts\Form\FormInterface as FormLayoutInterface;
use GI\DOM\HTML\Element\Input\Button\ButtonInterface;
use GI\DOM\HTML\Element\Input\DateTime\MonthInterface;

trait ContentsTrait
{
    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    /**
     * @var DivInterface
     */
    private $container;

    /**
     * @var FormLayoutInterface
     */
    private $navigationForm;

    /**
     * @var MonthInterface
     */
    private $navigationMonth;

    /**
     * @var ButtonInterface
     */
    private $navigationSubmitButton;

    /**
     * @var TableInterface
     */
    private $contentTable;

    /**
     * @var TRInterface
     */
    private $contentHeadRow;


    /**
     * @return ViewModelInterface
     */
    protected function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param ViewModelInterface $viewModel
     * @return static
     */
    public function setViewModel(ViewModelInterface $viewModel)
    {
        $this->viewModel = $viewModel;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateViewModel()
    {
        if (!($this->viewModel instanceof ViewModelInterface)) {
            $this->giThrowInvalidTypeException('View model', '', 'ViewModelInterface');
        }
    }

    /**
     * @return DivInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return FormLayoutInterface
     */
    public function getNavigationForm()
    {
        return $this->navigationForm;
    }

    /**
     * @return MonthInterface
     */
    public function getNavigationMonth()
    {
        return $this->navigationMonth;
    }

    /**
     * @return ButtonInterface
     */
    public function getNavigationSubmitButton()
    {
        return $this->navigationSubmitButton;
    }

    /**
     * @return TableInterface
     */
    public function getContentTable()
    {
        return $this->contentTable;
    }

    /**
     * @return TRInterface
     */
    public function getContentHeadRow()
    {
        return $this->contentHeadRow;
    }
}