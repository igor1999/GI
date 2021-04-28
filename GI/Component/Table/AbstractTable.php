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
namespace GI\Component\Table;

use GI\Component\Base\AbstractComponent;
use GI\Component\Table\ViewModel\Order as ViewModel;

use GI\Component\Table\ViewModel\OrderInterface as ViewModelInterface;
use GI\Component\Table\View\WidgetInterface;
use GI\Component\Paging\Base\PagingInterface;

abstract class AbstractTable extends AbstractComponent implements TableInterface
{
    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    /**
     * @var mixed
     */
    private $dataSource;


    /**
     * AbstractTable constructor.
     * @param mixed|null $dataSource
     * @param ViewModelInterface|null $viewModel
     * @throws \Exception
     */
    public function __construct($dataSource = null, ViewModelInterface $viewModel = null)
    {
        $this->dataSource = $dataSource;

        $this->viewModel = ($viewModel instanceof ViewModelInterface)
            ? $viewModel
            : $this->giGetDi(ViewModelInterface::class, ViewModel::class);
    }
    /**
     * @return WidgetInterface
     */
    abstract protected function getView();

    /**
     * @return ViewModelInterface
     */
    public function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @return mixed
     */
    protected function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * @param mixed $dataSource
     * @return static
     */
    protected function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    /**
     * @param PagingInterface $paging
     * @return static
     * @throws \Exception
     */
    public function setPagingRelation(PagingInterface $paging)
    {
        $this->getView()->setPagingRelation($paging);

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
            ->setDataSource($this->getDataSource())
            ->toString();
    }
}