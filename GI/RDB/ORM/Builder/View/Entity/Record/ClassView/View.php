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
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\RecordProperty\View as RecordPropertyView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\SetProperty\View as SetPropertyView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\RecordGetter\View as RecordGetterView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\SetGetter\View as SetGetterView;

use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Property\ViewInterface as ColumnPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Methods\ViewInterface as ColumnMethodsViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\RecordProperty\ViewInterface
    as RecordPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\SetProperty\ViewInterface as SetPropertyViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\RecordGetter\ViewInterface as RecordGetterViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\SetGetter\ViewInterface as SetGetterViewInterface;

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
     * @var RecordPropertyViewInterface
     */
    private $recordPropertyView;

    /**
     * @var SetPropertyViewInterface
     */
    private $setPropertyView;

    /**
     * @var RecordGetterViewInterface
     */
    private $recordGetterView;

    /**
     * @var SetGetterViewInterface
     */
    private $setGetterView;


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

        $this->recordPropertyView = $this->giGetDi(
            RecordPropertyViewInterface::class, RecordPropertyView::class
        );

        $this->setPropertyView = $this->giGetDi(
            SetPropertyViewInterface::class, SetPropertyView::class
        );

        $this->recordGetterView = $this->giGetDi(
            RecordGetterViewInterface::class, RecordGetterView::class
        );

        $this->setGetterView = $this->giGetDi(
            SetGetterViewInterface::class, SetGetterView::class
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
     * @return RecordPropertyViewInterface
     */
    public function getRecordPropertyView()
    {
        return $this->recordPropertyView;
    }

    /**
     * @return SetPropertyViewInterface
     */
    public function getSetPropertyView()
    {
        return $this->setPropertyView;
    }

    /**
     * @return RecordGetterViewInterface
     */
    public function getRecordGetterView()
    {
        return $this->recordGetterView;
    }

    /**
     * @return SetGetterViewInterface
     */
    public function getSetGetterView()
    {
        return $this->setGetterView;
    }
}