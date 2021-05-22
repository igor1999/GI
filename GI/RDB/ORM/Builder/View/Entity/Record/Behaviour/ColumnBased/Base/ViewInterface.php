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
namespace GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Base;

use GI\Markup\Renderer\RendererInterface as BaseInterface;
use GI\RDB\Meta\Column\ColumnInterface;

/**
 * Interface ViewInterface
 * @package GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Base
 *
 * @method ColumnInterface getColumn()
 * @method ViewInterface setColumn(ColumnInterface $column)
 */
interface ViewInterface extends BaseInterface
{
    /**
     * @param ColumnInterface $column
     * @return string
     */
    public function getNullForDoc(ColumnInterface $column);
}