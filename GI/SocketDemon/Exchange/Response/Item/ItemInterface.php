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
namespace GI\SocketDemon\Exchange\Response\Item;

use GI\Pattern\ArrayExchange\ArrayExchangeInterface;
use GI\Pattern\Validation\ValidationInterface;

interface ItemInterface extends ArrayExchangeInterface, ValidationInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     * @return static
     */
    public function setId(string $id);

    /**
     * @return string
     */
    public function hasData();

    /**
     * @return string
     */
    public function getData();

    /**
     * @param string $data
     * @return static
     */
    public function setData(string $data);

    /**
     * @return bool
     */
    public function isConfirmed();

    /**
     * @param bool $confirmed
     * @return static
     */
    public function setConfirmed(bool $confirmed);

    /**
     * @return bool
     */
    public function isKill();

    /**
     * @param bool $kill
     * @return static
     */
    public function setKill(bool $kill);
}