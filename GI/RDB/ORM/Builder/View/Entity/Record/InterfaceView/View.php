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
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\RecordSignature\View as RecordSignatureView;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\SetSignature\View as SetSignatureView;

use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\ColumnBased\Signatures\ViewInterface
    as ColumnSignaturesViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\RecordSignature\ViewInterface
    as RecordSignatureViewInterface;
use GI\RDB\ORM\Builder\View\Entity\Record\Behaviour\TableBased\SetSignature\ViewInterface as SetSignatureViewInterface;

class View extends Base implements ViewInterface
{
    /**
     * @var ColumnSignaturesViewInterface
     */
    private $columnSignaturesView;

    /**
     * @var RecordSignatureViewInterface
     */
    private $recordSignatureView;

    /**
     * @var SetSignatureViewInterface
     */
    private $setSignatureView;


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

        $this->recordSignatureView = $this->giGetDi(
            RecordSignatureViewInterface::class, RecordSignatureView::class
        );

        $this->setSignatureView = $this->giGetDi(
            SetSignatureViewInterface::class, SetSignatureView::class
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
     * @return RecordSignatureViewInterface
     */
    public function getRecordSignatureView()
    {
        return $this->recordSignatureView;
    }

    /**
     * @return SetSignatureViewInterface
     */
    public function getSetSignatureView()
    {
        return $this->setSignatureView;
    }
}