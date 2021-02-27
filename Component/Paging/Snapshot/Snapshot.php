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
namespace GI\Component\Paging\Snapshot;

use GI\Component\Paging\Base\AbstractPaging;
use GI\ClientContents\Paging\Snapshot\Paging as PagingModel;
use GI\Component\Paging\Base\View\Chain\Widget;

use GI\Component\Paging\Base\View\Chain\WidgetInterface;
use GI\ClientContents\Paging\Snapshot\PagingInterface as PagingModelInterface;
use GI\Component\Paging\Base\ViewModel\ViewModelInterface;

class Snapshot extends AbstractPaging implements SnapshotInterface
{
    /**
     * @var WidgetInterface
     */
    private $view;

    /**
     * @var PagingModelInterface
     */
    private $pagingModel;


    /**
     * Common constructor.
     * @param ViewModelInterface|null $viewModel
     * @param int $entriesTotal
     * @throws \Exception
     */
    public function __construct(ViewModelInterface $viewModel = null, int $entriesTotal = 0)
    {
        parent::__construct($viewModel, $entriesTotal);

        $this->view = $this->giGetDi(WidgetInterface::class, Widget::class);
    }


    /**
     * @return WidgetInterface
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param int $entriesTotal
     * @param int $selectedPage
     * @param int|null $entriesProPage
     * @return static
     * @throws \Exception
     */
    protected function createPagingModel(int $entriesTotal, int $selectedPage = 1, int $entriesProPage = null)
    {
        $this->pagingModel = $this->giGetDi(
            PagingModelInterface::class,
            PagingModel::class,
            [$entriesTotal, $selectedPage, $entriesProPage]
        );

        return $this;
    }

    /**
     * @return PagingModelInterface
     */
    public function getPagingModel()
    {
        return $this->pagingModel;
    }
}