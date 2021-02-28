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
namespace GI\ClientContents\TableHeader\Column;

use GI\ClientContents\TableHeader\Column\DataSource\DataSource;
use GI\ClientContents\TableHeader\Column\Order\Order;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\TableHeader\Column\DataSource\DataSourceInterface;
use GI\ClientContents\TableHeader\Column\Order\OrderInterface;

class Column implements ColumnInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $caption = '';

    /**
     * @var DataSourceInterface
     */
    private $dataSource;

    /**
     * @var OrderInterface
     */
    private $order;


    /**
     * Column constructor.
     * @param string $id
     * @param string $caption
     */
    public function __construct(string $id, string $caption)
    {
        $this->id      = $id;
        $this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return bool
     */
    public function hasDataSource()
    {
        return $this->dataSource instanceof DataSourceInterface;
    }

    /**
     * @return DataSourceInterface
     * @throws \Exception
     */
    public function getDataSource()
    {
        if (!$this->hasDataSource()) {
            $this->giThrowNotSetException('Data source');
        }

        return $this->dataSource;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function createDataSource()
    {
        $this->dataSource = $this->giGetDi(DataSourceInterface::class, DataSource::class);

        return $this;
    }

    /**
     * @return static
     */
    public function removeDataSource()
    {
        $this->dataSource = null;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasOrder()
    {
        return $this->order instanceof OrderInterface;
    }

    /**
     * @return OrderInterface
     * @throws \Exception
     */
    public function getOrder()
    {
        if (!$this->hasOrder()) {
            $this->giThrowNotSetException('Order');
        }

        return $this->order;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function createOrder()
    {
        $this->order = $this->giGetDi(OrderInterface::class, Order::class);

        return $this;
    }

    /**
     * @return static
     */
    public function removeOrder()
    {
        $this->order = null;

        return $this;
    }
}