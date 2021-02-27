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
namespace GI\ClientContents\TableHeader\Column\DataSource;

interface DataSourceInterface
{
    /**
     * @return string
     */
    public function getDataAttribute();

    /**
     * @param string $dataAttribute
     * @return static
     */
    public function setDataAttribute(string $dataAttribute);

    /**
     * @return string
     */
    public function getType();

    /**
     * @return static
     */
    public function setTypeToDataAttribute();

    /**
     * @return static
     */
    public function setTypeToRowNumber();

    /**
     * @return bool
     */
    public function isTypeDataAttribute();

    /**
     * @return bool
     */
    public function isTypeRowNumber();

    /**
     * @param mixed $source
     * @param int $rowNumber
     * @return mixed
     * @throws \Exception
     */
    public function get($source, int $rowNumber);
}