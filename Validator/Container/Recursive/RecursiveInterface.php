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
namespace GI\Validator\Container\Recursive;

use GI\Validator\Container\ContainerInterface;
use GI\Validator\ValidatorInterface;

interface RecursiveInterface extends ContainerInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key);

    /**
     * @param string $key
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param ValidatorInterface $validator
     * @return static
     */
    public function set(string $key, ValidatorInterface $validator);

    /**
     * @return array
     * @throws \Exception
     */
    public function getMessages();

    /**
     * @param bool $required
     * @return static
     */
    public function setRequiredForItems(bool $required);

    /**
     * @param string $key
     * @return bool
     */
    public function remove(string $key);
}