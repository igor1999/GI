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
namespace GI\FileSystem\FSO\FSODir;

class ClassDir extends FSODir implements ClassDirInterface
{
    /**
     * @var string[]
     */
    private static $cache = [];

    /**
     * @var string
     */
    private $class = '';


    /**
     * ClassDir constructor.
     * @param string $class
     * @throws \Exception
     */
    public function __construct(string $class)
    {
        if (!isset(self::$cache[$class])) {
            self::$cache[$class] = $this->createDir($class);
        }

        $this->class = $class;

        parent::__construct(self::$cache[$class]);
    }

    /**
     * @param string $class
     * @return string
     * @throws \Exception
     */
    protected function createDir(string $class)
    {
        return dirname($this->giGetClassMeta($class)->getReflection()->getFileName());
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}