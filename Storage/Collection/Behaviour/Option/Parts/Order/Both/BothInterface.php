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

interface BothInterface
{
    const ORDER_ASC      = 'asc';

    const ORDER_DESC     = 'desc';

    const ORDER_KEY_ASC  = 'key_asc';

    const ORDER_KEY_DESC = 'key_desc';


    /**
     * @return bool
     */
    public function isOrdered();

    /**
     * @return bool
     */
    public function isOrderedAsc();

    /**
     * @return bool
     */
    public function isOrderedDesc();

    /**
     * @return bool
     */
    public function isOrderedKeyAsc();

    /**
     * @return bool
     */
    public function isOrderedKeyDesc();

    /**
     * @return static
     */
    public function unsetOrdered();

    /**
     * @return static
     */
    public function setOrderedToAsc();

    /**
     * @return static
     */
    public function setOrderedToDesc();

    /**
     * @return static
     */
    public function setOrderedToKeyAsc();

    /**
     * @return static
     */
    public function setOrderedToKeyDesc();
}