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

use GI\RDB\ORM\Builder\View\Entity\Base\AbstractView as Base;

use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Property\View as ColumnPropertyView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Methods\View as ColumnMethodsView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ParentRefProperty\View
    as ParentRefPropertyView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ChildRefProperty\View
    as ChildRefPropertyView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ParentRefGetter\View
    as ParentRefGetterView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ChildRefGetter\View
    as ChildRefGetterView;

use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Property\ViewInterface as ColumnPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Methods\ViewInterface as ColumnMethodsViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ParentRefProperty\ViewInterface
    as ParentRefPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ChildRefProperty\ViewInterface
    as ChildRefPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ParentRefGetter\ViewInterface
    as ParentRefGetterViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ChildRefGetter\ViewInterface
    as ChildRefGetterViewInterface;

class View extends Base implements ViewInterface
{
    /**
     * @var ColumnPropertyViewInterface
     */
    private $columnPropertyView;

    /**
     * @var ColumnMethodsViewInterface
     */
    private $columnMethodsView;

    /**
     * @var ParentRefPropertyViewInterface
     */
    private $parentRefPropertyView;

    /**
     * @var ChildRefPropertyViewInterface
     */
    private $childRefPropertyView;

    /**
     * @var ParentRefGetterViewInterface
     */
    private $parentRefGetterView;

    /**
     * @var ChildRefGetterViewInterface
     */
    private $childRefGetterView;


    /**
     * View constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->columnPropertyView = $this->giGetDi(
            ColumnPropertyViewInterface::class, ColumnPropertyView::class
        );

        $this->columnMethodsView = $this->giGetDi(
            ColumnMethodsViewInterface::class, ColumnMethodsView::class
        );

        $this->parentRefPropertyView = $this->giGetDi(
            ParentRefPropertyViewInterface::class, ParentRefPropertyView::class
        );

        $this->childRefPropertyView = $this->giGetDi(
            ChildRefPropertyViewInterface::class, ChildRefPropertyView::class
        );

        $this->parentRefGetterView = $this->giGetDi(
            ParentRefGetterViewInterface::class, ParentRefGetterView::class
        );

        $this->childRefGetterView = $this->giGetDi(
            ChildRefGetterViewInterface::class, ChildRefGetterView::class
        );
    }

    /**
     * @return ColumnPropertyViewInterface
     */
    public function getColumnPropertyView()
    {
        return $this->columnPropertyView;
    }

    /**
     * @return ColumnMethodsViewInterface
     */
    public function getColumnMethodsView()
    {
        return $this->columnMethodsView;
    }

    /**
     * @return ParentRefPropertyViewInterface
     */
    public function getParentRefPropertyView()
    {
        return $this->parentRefPropertyView;
    }

    /**
     * @return ChildRefPropertyViewInterface
     */
    public function getChildRefPropertyView()
    {
        return $this->childRefPropertyView;
    }

    /**
     * @return ParentRefGetterViewInterface
     */
    public function getParentRefGetterView()
    {
        return $this->parentRefGetterView;
    }

    /**
     * @return ChildRefGetterViewInterface
     */
    public function getChildRefGetterView()
    {
        return $this->childRefGetterView;
    }
}