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
namespace GI\FileSystem\FSO\FSODir\Behaviour;

use GI\FileSystem\FSO\Collection\ArrayList\ArrayList as FSOArrayList;

use GI\FileSystem\FSO\FSODir\FSODirInterface;

class Children extends FSOArrayList implements ChildrenInterface
{
    /**
     * Children constructor.
     * @param FSODirInterface $parentDir
     * @throws \Exception
     */
    public function __construct(FSODirInterface $parentDir)
    {
        parent::__construct();

        $parentDir->fireInexistence();

        foreach (scandir($parentDir->getPath()) as $name) {
            if (in_array($name, ['.', '..'])) {
                continue;
            }

            $file    = $parentDir->createChildFile($name);
            $dir     = $parentDir->createChildDir($name);
            $symlink = $parentDir->createChildSymlink($name);

            if ($file->isFile()) {
                $this->add($file);
            } elseif ($dir->isDir()) {
                $this->add($dir);
            } elseif ($symlink->isLink()) {
                $this->add($symlink);
            }
        }
    }
}