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
namespace GI\Component\Table\ViewModel;

use GI\ViewModel\AbstractViewModel as Base;
use GI\Component\Paging\Base\ViewModel\ViewModel as PagingViewModel;

use GI\Component\Paging\Base\ViewModel\ViewModelInterface as PagingViewModelInterface;

class ViewModel extends Base implements ViewModelInterface
{
    /**
     * @var OrderInterface
     */
    private $order;

    /**
     * @var PagingViewModelInterface
     */
    private $paging;


    /**
     * ViewModel constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->order = $this->giGetDi(OrderInterface::class, Order::class);
        $this->order->setViewModelParent($this)->setFilterAndValidatorToParent();

        $this->paging = $this->giGetDi(PagingViewModelInterface::class, PagingViewModel::class);
        $this->paging->setViewModelParent($this)->setFilterAndValidatorToParent();
    }

    /**
     * @extract
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @hydrate
     * @param array $contents
     * @return static
     */
    protected function setOrder(array $contents)
    {
        $this->getOrder()->hydrate($contents);

        return $this;
    }

    /**
     * @extract
     * @return PagingViewModelInterface
     */
    public function getPaging()
    {
        return $this->paging;
    }

    /**
     * @hydrate
     * @param array $contents
     * @return static
     */
    protected function setPaging(array $contents)
    {
        $this->getPaging()->hydrate($contents);

        return $this;
    }
}