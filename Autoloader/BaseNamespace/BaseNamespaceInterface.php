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
namespace GI\Autoloader\BaseNamespace;

interface BaseNamespaceInterface
{
    const PSR4 = 4;

    const PSR0 = 0;


    /**
     * @return string
     */
    public function getBaseNamespace();

    /**
     * @return string
     */
    public function getBaseDirectory();

    /**
     * @return int|\Closure
     */
    public function getPsr();

    /**
     * @return string
     */
    public function getExtension();

    /**
     * @param string $class
     * @return string|bool
     */
    public function createFile(string $class);

    /**
     * @return bool
     */
    public function isPsr4();

    /**
     * @return bool
     */
    public function isPsr0();

    /**
     * @return bool
     */
    public function isPsrClosure();
}