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
namespace GI\FileSystem\Stream\Reader;

use GI\FileSystem\Stream\StreamInterface;

interface ReaderInterface extends StreamInterface
{
    /**
     * @param \Closure $callback
     * @param int $length
     * @return static
     * @throws \Exception
     */
    public function readLines(\Closure $callback, int $length = 0);

    /**
     * @param \Closure $callback
     * @param int $length
     * @return static
     * @throws \Exception
     */
    public function readLinesAndClose(\Closure $callback, int $length = 0);

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function readAndClose(int $length);
}