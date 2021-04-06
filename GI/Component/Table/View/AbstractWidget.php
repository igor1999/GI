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
namespace GI\Component\Table\View;

use GI\Component\Base\View\Widget\AbstractWidget as Base;

use GI\Component\Table\ViewModel\OrderInterface as ViewModelInterface;
use GI\Component\Paging\Base\PagingInterface;
use GI\ClientContents\TableHeader\Column\ColumnInterface;
use GI\DOM\HTML\Element\Form\FormInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\DOM\HTML\Element\Table\TableInterface;
use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\ClientContents\TableHeader\TableHeaderInterface;
use GI\RDB\ORM\Set\SetInterface;

/**
 * Class AbstractWidget
 * @package GI\Component\Table\View
 *
 * @method ViewModelInterface getViewModel()
 * @method WidgetInterface setViewModel(ViewModelInterface $viewModel)
 * @method getDataSource()
 * @method WidgetInterface setDataSource($dataSource)
 */
abstract class AbstractWidget extends Base implements WidgetInterface
{
    use ContentsTrait;


    const CLIENT_CSS = 'gi-table';

    const CLIENT_JS  = self::CLIENT_CSS;


    const PAGING_RELATION = 'paging';


    const GI_ID_ORDER_LINK = 'order-link';


    const CLASS_ASCENDANT  = 'gi-order-ascendant';

    const CLASS_DESCENDANT = 'gi-order-descendant';


    const ATTRIBUTE_HEADER_COLUMN_ID = 'column-id';

    const ATTRIBUTE_ORDER_CRITERIA   = 'order-criteria';

    const ATTRIBUTE_ORDER_DIRECTION  = 'order-direction';


    /**
     * @return ResourceRendererInterface
     */
    abstract protected function getResourceRenderer();

    /**
     * @return TableHeaderInterface
     */
    abstract protected function getHeaderModel();

    /**
     * @param PagingInterface $paging
     * @return static
     * @throws \Exception
     */
    public function setPagingRelation(PagingInterface $paging)
    {
        $this->getRelationList()->set(static::PAGING_RELATION, $paging);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $this->orderForm->getChildNodes()->set([$this->orderHidden, $this->directionHidden]);

        return $this;
    }

    /**
     * @gi-id order-hidden
     * @return HiddenInterface
     */
    protected function createOrderHidden()
    {
        $this->orderHidden = $this->giGetDOMFactory()->getInputFactory()->createHidden(
            $this->getViewModel()->getCriteriaName()
        );

        $this->addFormAttribute($this->orderHidden);

        return $this->orderHidden;
    }

    /**
     * @gi-id direction-hidden
     * @return HiddenInterface
     */
    protected function createDirectionHidden()
    {
        $this->directionHidden = $this->giGetDOMFactory()->getInputFactory()->createHidden(
            $this->getViewModel()->getDirectionName()
        );

        $this->addFormAttribute($this->directionHidden);

        return $this->directionHidden;
    }

    /**
     * @render
     * @gi-id order-form
     * @return FormInterface
     */
    protected function createOrderForm()
    {
        $this->orderForm = $this->giGetDOMFactory()->createForm();

        $this->addCommonFormId($this->orderForm);

        return $this->orderForm;
    }

    /**
     * @render
     * @gi-id table
     * @return TableInterface
     * @throws \Exception
     */
    protected function createTable()
    {
        $this->getHeaderModel()->setOrderAndDirection(
            $this->getViewModel()->getCriteria(), $this->getViewModel()->getDirection()
        );

        $this->table = $this->giGetDOMFactory()->createTable();

        $dataSource = $this->getDataSource();
        if ($dataSource instanceof SetInterface) {
            $rowsNumber = $dataSource->getItems();
        } elseif ($dataSource instanceof ExtractionInterface) {
            $rowsNumber = count($dataSource->extract());
        } else {
            $rowsNumber = count($dataSource);
        }

        $this->table->build($rowsNumber, $this->getHeaderModel()->getLength(), true);

        $this->buildHeader()->fillTable();

        return $this->table;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function buildHeader()
    {
        $headRow = $this->table->getRow(0);

        foreach ($this->getHeaderModel()->getItems() as $index => $column) {
            $cell = $headRow->getChildNodes()->get($index);
            $this->buildHeaderCell($cell, $column);
        }

        return $this;
    }

    /**
     * @param TDInterface $cell
     * @param ColumnInterface $column
     * @return static
     * @throws \Exception
     */
    protected function buildHeaderCell(TDInterface $cell, ColumnInterface $column)
    {
        $cell->getAttributes()->set(static::ATTRIBUTE_HEADER_COLUMN_ID, $column->getId());

        try {
            if ($column->getOrder()->isAscendant()) {
                $cell->getClasses()->add(static::CLASS_ASCENDANT);
            } elseif ($column->getOrder()->isDescendant()) {
                $cell->getClasses()->add(static::CLASS_DESCENDANT);
            }

            $hyperlink = $this->giGetDOMFactory()->createHyperlink('', $column->getCaption())->setHrefToMock();
            $hyperlink->getAttributes()->setDataAttribute(
                static::ATTRIBUTE_ORDER_CRITERIA, $column->getOrder()->getCriteria()
            );
            $hyperlink->getAttributes()->setDataAttribute(
                static::ATTRIBUTE_ORDER_DIRECTION,
                $this->getViewModel()->getDirectionAsString($column->getOrder()->getNextDirection())
            );
            $this->addClientAttributes($hyperlink, static::GI_ID_ORDER_LINK);

            $cell->getChildNodes()->set($hyperlink);
        } catch (\Exception $e) {
            $cell->getChildNodes()->set($column->getCaption());
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function fillTable()
    {
        $dataSource = $this->getDataSource();
        if ($dataSource instanceof SetInterface) {
            $dataSource = $dataSource->getItems();
        } elseif ($dataSource instanceof ExtractionInterface) {
            $dataSource = $dataSource->extract();
        }

        $rowNumber = 1;

        foreach ($dataSource as $dataRow) {
            foreach ($this->getHeaderModel()->getItems() as $index => $column) {
                $this->fillColumn($rowNumber, $dataRow, $index, $column);
            }

            $rowNumber += 1;
        }

        return $this;
    }

    /**
     * @param int $rowNumber
     * @param mixed $dataRow
     * @param int $index
     * @param ColumnInterface $column
     * @return static
     */
    protected function fillColumn(int $rowNumber, $dataRow, int $index, ColumnInterface $column)
    {
        try {
            $this->table->set($rowNumber, $index, $column->getDataSource()->get($dataRow, $rowNumber));
        } catch (\Exception $e) {}

        return $this;
    }
}