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
namespace GI\FileSystem\Stream\Writer;

use GI\FileSystem\Stream\AbstractStream;

class Writer extends AbstractStream implements WriterInterface
{
    /**
     * @param string $data
     * @return static
     * @throws \Exception
     */
    public function write(string $data)
    {
        $this->validate();

        $position = 0;
        $done     = false;

        while (!$done) {
            $bytes     = fwrite($this->getHandle(), substr($data, $position));
            $position += $bytes;
            $done      = $bytes == 0;
        }

        return $this;
    }

    /**
     * @param string $data
     * @return static
     * @throws \Exception
     */
    public function writeAndClose(string $data)
    {
        $this->write($data)->close();

        return $this;
    }
}