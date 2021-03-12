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
namespace GI\RDB\ORM\Builder\View\Entity\Record\InterfaceView;

use GI\RDB\ORM\Builder\View\Entity\Base\AbstractView as Base;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Signatures\View
    as ColumnSignaturesView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ParentRefSignature\View
    as ParentRefSignatureView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ChildRefSignature\View
    as ChildRefSignatureView;

use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Signatures\ViewInterface
    as ColumnSignaturesViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ParentRefSignature\ViewInterface
    as ParentRefSignatureViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\ChildRefSignature\ViewInterface
    as ChildRefSignatureViewInterface;

class View extends Base implements ViewInterface
{
    /**
     * @var ColumnSignaturesViewInterface
     */
    private $columnSignaturesView;

    /**
     * @var ParentRefSignatureViewInterface
     */
    private $parentRefSignatureView;

    /**
     * @var ChildRefSignatureViewInterface
     */
    private $childRefSignatureView;


    /**
     * View constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->columnSignaturesView = $this->giGetDi(
            ColumnSignaturesViewInterface::class, ColumnSignaturesView::class
        );

        $this->parentRefSignatureView = $this->giGetDi(
            ParentRefSignatureViewInterface::class, ParentRefSignatureView::class
        );

        $this->childRefSignatureView = $this->giGetDi(
            ChildRefSignatureViewInterface::class, ChildRefSignatureView::class
        );
    }

    /**
     * @return ColumnSignaturesViewInterface
     */
    public function getColumnSignaturesView()
    {
        return $this->columnSignaturesView;
    }

    /**
     * @return ParentRefSignatureViewInterface
     */
    public function getParentRefSignatureView()
    {
        return $this->parentRefSignatureView;
    }

    /**
     * @return ChildRefSignatureViewInterface
     */
    public function getChildRefSignatureView()
    {
        return $this->childRefSignatureView;
    }
}