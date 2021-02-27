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

abstract class AbstractIntegral extends Base implements IntegralInterface
{
    /**
     * @var OrderInterface
     */
    private $order;


    /**
     * AbstractIntegral constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->order = $this->giGetDi(OrderInterface::class, Order::class);
        $this->order->setViewModelParent($this)->setFilterAndValidatorToParent();

        try {
            $this->createPaging()->getPaging()->setViewModelParent($this)->setFilterAndValidatorToParent();
        } catch (\Exception $e) {}
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
     * @throws \Exception
     */
    protected function setOrder(array $contents)
    {
        $this->getOrder()->hydrate($contents);

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function getPaging()
    {
        $this->giThrowNotSetException('Paging View Model');
    }

    /**
     * @return static
     */
    abstract protected function createPaging();

    /**
     * @hydrate
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    protected function setPaging(array $contents)
    {
        try {
            $this->getPaging()->hydrate($contents);
        } catch (\Exception $e) {}

        return $this;
    }
}