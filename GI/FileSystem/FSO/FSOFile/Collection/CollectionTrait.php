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
namespace GI\FileSystem\FSO\FSOFile\Collection;

use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

trait CollectionTrait
{
    /**
     * @var FSOFileInterface[]
     */
    private $items = [];


    /**
     * @param FSOFileInterface $file
     * @return FSOFileInterface[]
     */
    public function find(FSOFileInterface $file)
    {
        $f = function(FSOFileInterface $item) use ($file)
        {
            return $item->getPath() == $file->getPath();
        };

        return $this->filter($f);
    }

    /**
     * @return FSOFileInterface[]
     */
    public function findExistent()
    {
        $f = function(FSOFileInterface $item)
        {
            return $item->exists();
        };

        return $this->filter($f);
    }

    /**
     * @return FSOFileInterface[]
     */
    public function findInexistent()
    {
        $f = function(FSOFileInterface $item)
        {
            return !$item->exists();
        };

        return $this->filter($f);
    }

    /**
     * @param \Closure $filter
     * @return FSOFileInterface[]
     */
    public function filter(\Closure $filter)
    {
        return array_filter($this->items, $filter);
    }

    /**
     * @return FSOFileInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @param FSODirInterface $dir
     * @return static
     * @throws \Exception
     */
    public function makeCopy(FSODirInterface $dir)
    {
        foreach ($this->items as $item) {
            $localName = $item->getBasename();

            $item->makeCopy($dir->createChildFile($localName));
        }

        return $this;
    }

    /**
     * @return static
     */
    public function delete()
    {
        $f = function(FSOFileInterface $item)
        {
            return $item->delete();
        };
        array_map($f, $this->items);

        return $this;
    }
}