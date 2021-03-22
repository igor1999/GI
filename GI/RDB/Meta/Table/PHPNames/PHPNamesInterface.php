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
namespace GI\RDB\Meta\Table\PHPNames;

interface PHPNamesInterface
{
    /**
     * @return string
     */
    public function getSchemaNamespace();

    /**
     * @return string
     */
    public function getLocalNamespace();

    /**
     * @return string
     */
    public function getNamespace();

    /**
     * @return string
     */
    public function getDir();

    /**
     * @return string
     */
    public function getAlias();

    /**
     * @return string
     */
    public function getRecordClass();

    /**
     * @return string
     */
    public function getRecordInterface();

    /**
     * @return string
     */
    public function getSetClass();

    /**
     * @return string
     */
    public function getSetInterface();

    /**
     * @return string
     */
    public function getRecordClassAlias();

    /**
     * @return string
     */
    public function getRecordInterfaceAlias();

    /**
     * @return string
     */
    public function getSetClassAlias();

    /**
     * @return string
     */
    public function getSetInterfaceAlias();

    /**
     * @return string
     */
    public function getRecordProperty();

    /**
     * @return string
     */
    public function getSetProperty();

    /**
     * @return string
     */
    public function getRecordGetter();

    /**
     * @return string
     */
    public function getRecordCreator();

    /**
     * @return string
     */
    public function getSetGetter();

    /**
     * @return string
     */
    public function getSetCreator();
}