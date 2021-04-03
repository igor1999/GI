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
namespace GI\Meta\Constant\Collection;

use GI\Meta\Constant\ConstantInterface;

interface ImmutableInterface
{
    /**
     * @param string $constant
     * @return bool
     */
    public function has(string $constant);

    /**
     * @param string $constant
     * @return ConstantInterface
     * @throws \Exception
     */
    public function get(string $constant);

    /**
     * @return ConstantInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return ConstantInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @return ConstantInterface[]
     */
    public function getItems();

    /**
     * @return bool
     */
    public function getLength();

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param \Closure $closure
     * @return ConstantInterface[]
     */
    public function filter(\Closure $closure);
}