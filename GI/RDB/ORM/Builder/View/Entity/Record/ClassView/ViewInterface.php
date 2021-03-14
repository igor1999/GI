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
namespace GI\RDB\ORM\Builder\View\Entity\Record\ClassView;

use GI\RDB\ORM\Builder\View\Entity\Base\ViewInterface as BaseInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Methods\ViewInterface as ColumnMethodsViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Property\ViewInterface as ColumnPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ParentRefProperty\ViewInterface
    as RecordPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ChildRefProperty\ViewInterface
    as SetPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ParentRefGetter\ViewInterface
    as RecordGetterViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ChildRefGetter\ViewInterface as SetGetterViewInterface;

interface ViewInterface extends BaseInterface
{
    /**
     * @return ColumnPropertyViewInterface
     */
    public function getColumnPropertyView();

    /**
     * @return ColumnMethodsViewInterface
     */
    public function getColumnMethodsView();

    /**
     * @return RecordPropertyViewInterface
     */
    public function getRecordPropertyView();

    /**
     * @return SetPropertyViewInterface
     */
    public function getSetPropertyView();

    /**
     * @return RecordGetterViewInterface
     */
    public function getRecordGetterView();

    /**
     * @return SetGetterViewInterface
     */
    public function getSetGetterView();
}