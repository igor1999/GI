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
namespace GI\FileSystem\FSO;

use GI\Pattern\StringConvertable\StringConvertableInterface;
use GI\FileSystem\FileSystemInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\Meta\MetaInterface;
use GI\FileSystem\FSO\Symlink\SymlinkInterface;
use GI\FileSystem\FSO\Symlink\URLHolder\URLHolderInterface;

interface FSOInterface extends StringConvertableInterface, FileSystemInterface
{
    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getBasename();

    /**
     * @return string
     */
    public function getFilename();

    /**
     * @return string
     */
    public function getExtension();

    /**
     * @return int
     */
    public function getMode();

    /**
     * @return MetaInterface
     */
    public function getMeta();

    /**
     * @param int $mode
     * @return static
     */
    public function setMode(int $mode);

    /**
     * @return static
     */
    public function setModeToDefault();

    /**
     * @param int $up
     * @return FSODirInterface
     */
    public function createParent(int $up = 1);

    /**
     * @return bool
     */
    public function exists();

    /**
     * @return static
     * @throws \Exception
     */
    public function fireInexistence();

    /**
     * @param string $path
     * @return SymlinkInterface
     * @throws \Exception
     */
    public function createSymlink(string $path);

    /**
     * @param string $path
     * @return URLHolderInterface
     */
    public function createURLHolder(string $path);

    /**
     * @return static
     */
    public function create();

    /**
     * @return static
     */
    public function delete();
}