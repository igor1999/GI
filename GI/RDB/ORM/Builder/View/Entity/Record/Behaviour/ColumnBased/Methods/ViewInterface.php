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
namespace GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Methods;

use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Base\ViewInterface as BaseInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Getter\ViewInterface as GetterViewInterface;
use GI\RDB\Meta\Column\ColumnInterface;

interface ViewInterface extends BaseInterface
{
    /**
     * @return GetterViewInterface
     */
    public function getGetterView();

    /**
     * @param string $namespace
     * @return static
     */
    public function setORMNamespace(string $namespace);

    /**
     * @param ColumnInterface $column
     * @return string
     */
    public function getAccess(ColumnInterface $column);

    /**
     * @param ColumnInterface $column
     * @return string
     */
    public function getNullForArg(ColumnInterface $column);
}