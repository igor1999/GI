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
namespace GI\Storage\Collection\BoolCollection\ArrayList\Closable;

use GI\Storage\Collection\BoolCollection\ArrayList\Alterable\AlterableInterface;
use GI\Pattern\Closing\ClosingInterface;

interface ClosableInterface extends AlterableInterface, ClosingInterface
{
    /**
     * @param int $index
     * @return bool
     * @throws \Exception
     */
    public function remove(int $index);

    /**
     * @return bool
     * @throws \Exception
     */
    public function pop();

    /**
     * @param bool|null $needle
     * @return bool
     * @throws \Exception
     */
    public function removeItem(bool $needle = null);

    /**
     * @return static
     * @throws \Exception
     */
    public function clean();
}