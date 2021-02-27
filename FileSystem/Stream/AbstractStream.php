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
namespace GI\FileSystem\Stream;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class AbstractStream implements StreamInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var resource
     */
    private $handle;


    /**
     * AbstractStream constructor.
     * @param resource $handle
     */
    public function __construct($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function validate()
    {
        if (!is_resource($this->handle)) {
            $this->giThrowInvalidTypeException('Handle', $this->handle, 'resource');
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function rewind()
    {
        $this->validate();

        rewind($this->handle);

        return $this;
    }

    /**
     * @param int $size
     * @return static
     * @throws \Exception
     */
    public function truncate(int $size)
    {
        $this->validate();

        ftruncate($this->handle, $size);

        return $this;
    }

    /**
     * @param int $offset
     * @return static
     * @throws \Exception
     */
    public function seekSet(int $offset)
    {
        $this->validate();

        fseek($this->handle, $offset, SEEK_SET);

        return $this;
    }

    /**
     * @param int $offset
     * @return static
     * @throws \Exception
     */
    public function seekCUR(int $offset)
    {
        $this->validate();

        fseek($this->handle, $offset, SEEK_CUR);

        return $this;
    }

    /**
     * @param int $offset
     * @return static
     * @throws \Exception
     */
    public function seekEnd(int $offset)
    {
        $this->validate();

        fseek($this->handle, $offset, SEEK_END);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function close()
    {
        $this->validate();

        fclose($this->handle);

        return $this;
    }
}