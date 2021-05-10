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
namespace GI\RDB\SQL\Query\Table;

use GI\RDB\SQL\Query\AbstractQuery as Base;

abstract class AbstractQuery extends Base implements QueryInterface
{
    const DEFAULT_ORDERING   = '';


    /**
     * @var array
     */
    private $searchParams = [];

    /**
     * @var string
     */
    private $order = '';

    /**
     * @var bool
     */
    private $direction = true;

    /**
     * @var int
     */
    private $limit = 0;

    /**
     * @var int
     */
    private $offset = 0;


    /**
     * AbstractQuery constructor.
     */
    public function __construct()
    {
        $this->setOrderToDefault();
    }

    /**
     * @return array
     */
    protected function getSearchParams()
    {
        return $this->searchParams;
    }

    /**
     * @param array $searchParams
     * @return static
     */
    public function setSearchParams(array $searchParams = [])
    {
        $this->searchParams = array_filter($searchParams);

        return $this;
    }

    /**
     * @return string
     */
    protected function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $order
     * @return static
     */
    public function setOrder(string $order = '')
    {
        if (empty($order)) {
            $this->setOrderToDefault();
        } else{
            $this->order = $order;
        }

        return $this;
    }

    /**
     * @return static
     */
    public function setOrderToDefault()
    {
        $this->setOrder(static::DEFAULT_ORDERING);

        return $this;
    }

    /**
     * @return bool
     */
    protected function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param bool $direction
     * @return static
     */
    public function setDirection(bool $direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return int
     */
    protected function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return static
     */
    public function setLimit(int $limit = 0)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    protected function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return static
     */
    public function setOffset(int $offset = 0)
    {
        $this->offset = $offset;

        return $this;
    }
}