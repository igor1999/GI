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
namespace GI\Validator\Container\Chain;

use GI\Validator\ValidatorInterface;
use GI\Validator\Container\ContainerInterface;

interface ChainInterface extends ContainerInterface
{
    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return ValidatorInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @param ValidatorInterface $validator
     * @return static
     */
    public function add(ValidatorInterface $validator);

    /**
     * @param int $index
     * @param ValidatorInterface $validator
     * @return bool
     */
    public function insert(int $index, ValidatorInterface $validator);

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index);

    /**
     * @return array|string
     * @throws \Exception
     */
    public function getMessages();

    /**
     * @param string $validatedParam
     * @return static
     */
    public function setValidatedParam(string $validatedParam);
}