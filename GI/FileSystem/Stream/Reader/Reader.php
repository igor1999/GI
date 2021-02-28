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

use GI\FileSystem\Stream\AbstractStream;

class Reader extends AbstractStream implements ReaderInterface
{
    /**
     * @param \Closure $callback
     * @param int $length
     * @return static
     * @throws \Exception
     */
    public function readLines(\Closure $callback, int $length = 0)
    {
        $this->validate();

        while (true) {
            $buffer = ($length <= 0) ? fgets($this->getHandle()) : fgets($this->getHandle(), $length);

            if ($buffer === false) {
                if (!feof($this->getHandle())) {
                    $this->giThrowCommonException('Unexpected reading fail');
                }

                break;
            }

            call_user_func($callback, $buffer);
        }

        return $this;
    }

    /**
     * @param \Closure $callback
     * @param int $length
     * @return static
     * @throws \Exception
     */
    public function readLinesAndClose(\Closure $callback, int $length = 0)
    {
        $this->readLines($callback, $length)->close();

        return $this;
    }

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function readAndClose(int $length)
    {
        $this->validate();

        if ($length <= 0) {
            $this->giThrowInvalidMinimumException('Length', $length, 1);
        }

        $result = fread($this->getHandle(), $length);

        if ($result === false) {
            $this->giThrowCommonException('Unexpected reading fail');
        }

        $this->close();

        return $result;
    }
}