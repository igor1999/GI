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
namespace GI\Component\Paging\Base;

use GI\Component\Base\AbstractComponent;
use GI\Component\Paging\Base\ViewModel\ViewModel;

use GI\Component\Paging\Base\ViewModel\ViewModelInterface;
use GI\Component\Paging\Base\View\Base\WidgetInterface;
use GI\DOM\HTML\Element\Select\SelectInterface;

abstract class AbstractPaging extends AbstractComponent implements PagingInterface
{
    /**
     * @var ViewModelInterface
     */
    private $viewModel;


    /**
     * AbstractPaging constructor.
     * @param ViewModelInterface|null $viewModel
     * @param int $entriesTotal
     * @throws \Exception
     */
    public function __construct(ViewModelInterface $viewModel = null, int $entriesTotal = 0)
    {
        if ($viewModel instanceof ViewModelInterface) {
            $this->viewModel = $viewModel;
        } else {
            $this->viewModel = $this->getGiServiceLocator()->getDependency(ViewModelInterface::class, ViewModel::class);
        }

        $this->createPagingModel(
            $entriesTotal, $this->getViewModel()->getSelectedPage(), $this->getViewModel()->getEntriesProPage()
        );
    }
    /**
     * @return WidgetInterface
     */
    abstract protected function getView();

    /**
     * @return ViewModelInterface
     */
    protected function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param int $entriesTotal
     * @param int $selectedPage
     * @param int|null $entriesProPage
     * @return static
     */
    abstract protected function createPagingModel(int $entriesTotal, int $selectedPage = 1, int $entriesProPage = null);

    /**
     * @return string
     */
    public function getDescriptionForEntriesTotal()
    {
        return $this->getView()->getDescriptionForEntriesTotal();
    }

    /**
     * @return SelectInterface
     */
    public function getSizesSelect()
    {
        return $this->getView()->getSizesSelect();
    }

    /**
     * @param array $contents
     * @param int $entriesTotal
     * @return static
     */
    public function hydrate(array $contents, int $entriesTotal = 0)
    {
        $this->getViewModel()->hydrate($contents);

        $this->createPagingModel(
            $entriesTotal, $this->getViewModel()->getSelectedPage(), $this->getViewModel()->getEntriesProPage()
        );

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getView()
            ->setViewModel($this->getViewModel())
            ->setPagingModel($this->getPagingModel())
            ->toString();
    }
}