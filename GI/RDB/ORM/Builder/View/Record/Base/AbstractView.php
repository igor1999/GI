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
namespace GI\RDB\ORM\Builder\View\Record\Base;

use GI\Markup\Renderer\AbstractRenderer;
use GI\RDB\Meta\Column\ColumnInterface;
use GI\RDB\Meta\Table\TableInterface;

/**
 * Class View
 * @package GI\RDB\ORM\Builder\View\Record\Base
 *
 * @method TableInterface getTable()
 * @method ViewInterface setTable(TableInterface $table)
 *
 * @method string getBaseNamespace()
 * @method ViewInterface setBaseNamespace(string $namespace)
 *
 * @method string getBaseClass()
 * @method ViewInterface setBaseClass(string $class)
 */
abstract class AbstractView extends AbstractRenderer implements ViewInterface
{
    /**
     * @return string
     * @throws \Exception
     */
    public function getBaseClassShortName()
    {
        return $this->giGetClassMeta($this->getBaseClass())->getShortName();
    }

    /**
     * @param ColumnInterface $column
     * @return string
     */
    public function getAccess(ColumnInterface $column)
    {
        return $column->isIdentity() ? 'protected' : 'public';
    }
}