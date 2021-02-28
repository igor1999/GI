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

use GI\ClientContents\TableHeader\Column\DataSource\DataSourceInterface;
use GI\ClientContents\TableHeader\Column\Order\OrderInterface;

interface ColumnInterface 
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getCaption();

    /**
     * @return bool
     */
    public function hasDataSource();

    /**
     * @return DataSourceInterface
     * @throws \Exception
     */
    public function getDataSource();

    /**
     * @return static
     * @throws \Exception
     */
    public function createDataSource();

    /**
     * @return static
     */
    public function removeDataSource();

    /**
     * @return bool
     */
    public function hasOrder();

    /**
     * @return OrderInterface
     * @throws \Exception
     */
    public function getOrder();

    /**
     * @return static
     * @throws \Exception
     */
    public function createOrder();

    /**
     * @return static
     */
    public function removeOrder();
}