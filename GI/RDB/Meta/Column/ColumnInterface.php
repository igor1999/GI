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
namespace GI\RDB\Meta\Column;

use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\RDB\Meta\Table\TableInterface;
use GI\GI\RDB\Meta\Column\References\ReferencesInterface;

interface ColumnInterface extends ExtractionInterface
{
    /**
     * @return TableInterface
     */
    public function getTable();

    /**
     * @return int
     */
    public function getIndex();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getFullQualifiedName();

    /**
     * @return string
     */
    public function getType();

    /**
     * @extract
     * @return int
     */
    public function getLength();

    /**
     * @return mixed
     */
    public function getDefault();

    /**
     * @return bool
     */
    public function isPrimary();

    /**
     * @return bool
     */
    public function isNull();

    /**
     * @extract
     * @return bool
     */
    public function isIdentity();

    /**
     * @return string
     */
    public function getPHPType();

    /**
     * @return bool
     */
    public function isDatePHPType();

    /**
     * @return bool
     */
    public function isBoolPHPType();

    /**
     * @return string
     */
    public function getClassProperty();

    /**
     * @return string
     */
    public function getClassGetter();

    /**
     * @return string
     */
    public function getClassSetter();

    /**
     * @return ReferencesInterface
     * @throws \Exception
     */
    public function getParentReferenceList();
}