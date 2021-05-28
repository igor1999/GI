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
use GI\Component\Table\ViewModel\ViewModel;
use GI\Component\Table\ViewModel\Order\Order;

use GI\Component\Table\ViewModel\ViewModelInterface;
use GI\Component\Table\ViewModel\Order\OrderInterface;
use GI\Component\Table\ViewModel\Order\OrderAwareInterface;
use GI\Component\Table\View\ViewInterface;
use GI\RDB\ORM\Set\SetInterface;

abstract class AbstractTable extends AbstractComponent implements TableInterface
{
    /**
     * @var ViewModelInterface
     */
    private $viewModel;


    /**
     * AbstractTable constructor.
     * @param array $contents
     * @throws \Exception
     */
    public function __construct(array $contents = [])
    {
        $viewModel = $this->getViewModel();

        $viewModel->hydrate($contents);

        $viewModel->filter();
    }

    /**
     * @return ViewInterface
     */
    abstract protected function getView();

    /**
     * @return ViewModelInterface
     * @throws \Exception
     */
    protected function getViewModel()
    {
        if (!($this->viewModel instanceof ViewModelInterface)) {
            $this->viewModel = $this->getGiServiceLocator()->getDependency(ViewModelInterface::class, ViewModel::class);
        }

        return $this->viewModel;
    }

    /**
     * @return mixed
     */
    abstract protected function getDataSource();

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $dataSource = $this->getDataSource();
        if ($dataSource instanceof SetInterface) {
            $dataSource = $dataSource->getItems();
        }

        $viewModel = $this->getViewModel();
        if ($viewModel instanceof OrderAwareInterface) {
            $orderModel = $viewModel->getOrder();
        } else {
            $orderModel = $this->getGiServiceLocator()->getDependency(OrderInterface::class, Order::class);
        }

        $this->getView()->getWidget()->setViewModel($orderModel)->setDataSource($dataSource);

        return $this->getView()->toString();
    }
}