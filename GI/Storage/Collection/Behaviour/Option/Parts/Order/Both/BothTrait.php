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
namespace GI\Storage\Collection\Behaviour\Option\Parts\Order\Both;

trait BothTrait
{
    /**
     * @var string
     */
    private $ordered = '';


    /**
     * @return string
     */
    protected function getOrdered()
    {
        return $this->ordered;
    }

    /**
     * @param string $ordered
     * @return static
     */
    protected function setOrdered(string $ordered = '')
    {
        $this->ordered = $ordered;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOrdered()
    {
        return !empty($this->ordered);
    }

    /**
     * @return bool
     */
    public function isOrderedAsc()
    {
        return ($this->ordered == self::ORDER_ASC);
    }

    /**
     * @return bool
     */
    public function isOrderedDesc()
    {
        return ($this->ordered == self::ORDER_DESC);
    }

    /**
     * @return bool
     */
    public function isOrderedKeyAsc()
    {
        return ($this->ordered == self::ORDER_KEY_ASC);
    }

    /**
     * @return bool
     */
    public function isOrderedKeyDesc()
    {
        return ($this->ordered == self::ORDER_KEY_DESC);
    }

    /**
     * @return static
     */
    public function unsetOrdered()
    {
        $this->setOrdered();

        return $this;
    }

    /**
     * @return static
     */
    public function setOrderedToAsc()
    {
        $this->setOrdered(self::ORDER_ASC);

        return $this;
    }

    /**
     * @return static
     */
    public function setOrderedToDesc()
    {
        $this->setOrdered(self::ORDER_DESC);

        return $this;
    }

    /**
     * @return static
     */
    public function setOrderedToKeyAsc()
    {
        $this->setOrdered(self::ORDER_KEY_ASC);

        return $this;
    }

    /**
     * @return static
     */
    public function setOrderedToKeyDesc()
    {
        $this->setOrdered(self::ORDER_KEY_DESC);

        return $this;
    }
}