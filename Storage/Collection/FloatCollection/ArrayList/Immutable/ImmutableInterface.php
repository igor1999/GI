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
namespace GI\Storage\Collection\FloatCollection\ArrayList\Immutable;

use GI\Storage\Collection\FloatCollection\CollectionInterface;
use GI\Storage\Collection\Behaviour\Service\FloatCollection\ArrayList\ArrayListInterface as ServiceInterface;

interface ImmutableInterface extends CollectionInterface
{
    /**
     * @return ServiceInterface
     */
    public function getService();

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index);

    /**
     * @param int $index
     * @return float
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @param int $index
     * @param float|mixed $default
     * @return float|mixed
     */
    public function getOptional(int $index, $default = 0);

    /**
     * @return float
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return float
     * @throws \Exception
     */
    public function getLast();
}