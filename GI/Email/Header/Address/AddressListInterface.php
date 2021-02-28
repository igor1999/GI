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
namespace GI\Email\Header\Address;

use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\Pattern\StringConvertable\StringConvertableInterface;

interface AddressListInterface extends ExtractionInterface, StringConvertableInterface
{
    const SEPARATOR = ',';


    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return AddressInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return AddressInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param AddressInterface $item
     * @return static
     */
    public function add(AddressInterface $item);

    /**
     * @param string $email
     * @param string $name
     * @return static
     * @throws \Exception
     */
    public function createAndAdd(string $email, string $name = '');

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index);

    /**
     * @return static
     */
    public function clean();

    /**
     * @return static
     * @throws \Exception
     */
    public function validateIfNotEmpty();

    /**
     * @return array
     */
    public function extract();
}