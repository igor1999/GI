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

use GI\Component\Paging\Base\ViewModel\ViewModelInterface;
use GI\ClientContents\Paging\Base\PagingInterface;
use GI\DOM\HTML\Element\Form\FormInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Select\SelectInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Div\DivInterface;

trait ContentsTrait
{
    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    /**
     * @var PagingInterface
     */
    private $pagingModel;

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
     * @return PagingInterface
     */
    protected function getPagingModel()
    {
        return $this->pagingModel;
    }

    /**
     * @param PagingInterface $pagingModel
     * @return static
     */
    public function setPagingModel(PagingInterface $pagingModel)
    {
        $this->pagingModel = $pagingModel;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validatePagingModel()
    {
        if (!($this->pagingModel instanceof PagingInterface)) {
            $this->giThrowInvalidTypeException('Paging model', '', 'PagingInterface');
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return LayoutInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return SelectInterface
     */
    public function getSizesSelect()
    {
        return $this->sizesSelect;
    }

    /**
     * @return HiddenInterface
     */
    public function getSelectedPageHidden()
    {
        return $this->selectedPageHidden;
    }

    /**
     * @return DivInterface
     */
    public function getNaviToFirst()
    {
        return $this->naviToFirst;
    }

    /**
     * @return DivInterface
     */
    public function getNaviToPrev()
    {
        return $this->naviToPrev;
    }

    /**
     * @return DivInterface
     */
    public function getNaviToNext()
    {
        return $this->naviToNext;
    }

    /**
     * @return DivInterface
     */
    public function getNaviToLast()
    {
        return $this->naviToLast;
    }
}