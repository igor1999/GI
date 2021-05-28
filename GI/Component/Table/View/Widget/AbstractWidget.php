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
namespace GI\Component\Table\View\Widget;

use GI\Component\Base\View\Widget\AbstractWidget as Base;

use GI\Component\Table\ViewModel\Order\OrderInterface as ViewModelInterface;
use GI\Component\Paging\Base\PagingInterface;
use GI\DOM\HTML\Element\Form\FormInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;
use GI\DOM\HTML\Element\Table\TableInterface;
use GI\Component\Table\View\Widget\Template\TemplateInterface;

/**
 * Class AbstractWidget
 * @package GI\Component\Table\View
 *
 * @method ViewModelInterface getViewModel()
 * @method WidgetInterface setViewModel(ViewModelInterface $viewModel)
 * @method array getDataSource()
 * @method WidgetInterface setDataSource(array $dataSource)
 */
abstract class AbstractWidget extends Base implements WidgetInterface
{
    const CLIENT_CSS = 'gi-table';

    const CLIENT_JS  = self::CLIENT_CSS;


    const PAGING_RELATION = 'paging';


    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @var THInterface[]
     */
    private $headerCells = [];

    /**
     * @var HiddenInterface
     */
    private $orderHidden;

    /**
     * @var HiddenInterface
     */
    private $directionHidden;

    /**
     * @var FormInterface
     */
    private $orderForm;


    /**
     * @return ResourceRendererInterface
     */
    abstract protected function getResourceRenderer();

    /**
     * @return TemplateInterface
     */
    abstract protected function getTemplate();

    /**
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    protected function hasHeaderCell(string $id)
    {
        $this->getTable();

        return isset($this->headerCells[$id]);
    }

    /**
     * @param string $id
     * @return THInterface
     * @throws \Exception
     */
    protected function getHeaderCell(string $id)
    {
        if (!$this->hasHeaderCell($id)) {
            $this->getGiServiceLocator()->throwNotInScopeException($id);
        }

        return $this->headerCells[$id];
    }

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
    protected function getOrderHidden()
    {
        if (!($this->orderHidden instanceof HiddenInterface)) {
            $this->orderHidden = $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createHidden(
                $this->getViewModel()->getCriteriaName(), $this->getViewModel()->getCriteria()
            );

            $this->addFormAttribute($this->orderHidden);
        }

        return $this->orderHidden;
    }

    /**
     * @gi-id direction-hidden
     * @return HiddenInterface
     */
    protected function getDirectionHidden()
    {
        if (!($this->directionHidden instanceof HiddenInterface)) {
            $this->directionHidden = $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createHidden(
                $this->getViewModel()->getDirectionName(), $this->getViewModel()->getDirection()
            );

            $this->addFormAttribute($this->directionHidden);
        }

        return $this->directionHidden;
    }

    /**
     * @render
     * @gi-id order-form
     * @return FormInterface
     */
    protected function getOrderForm()
    {
        if (!($this->orderForm instanceof FormInterface)) {
            $this->orderForm = $this->getGiServiceLocator()->getDOMFactory()->createForm();

            $this->addCommonFormId($this->orderForm);
        }

        return $this->orderForm;
    }

    /**
     * @render
     * @gi-id table
     * @return TableInterface
     * @throws \Exception
     */
    protected function getTable()
    {
        $this->table = $this->getGiServiceLocator()->getDOMFactory()->createTable();
        $this->table->getChildNodes()->addRow();

        $this->createHeader();

        $index = 1;
        foreach ($this->getDataSource() as $dataItem) {
            $this->table->getChildNodes()->addRow();
            $row = $this->table->getRow($index);

            foreach ($this->getTemplate()->getItems() as $id => $cellItem) {
                $cell = $cellItem->createBodyCell($this, $index, $dataItem);

                $row->getChildNodes()->addCell($cell);
            }

            $index += 1;
        }

        return $this->table;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createHeader()
    {
        $row = $this->table->getRow(0);

        $criteria  = $this->getViewModel()->getCriteria();
        $direction = $this->getViewModel()->getDirectionAsBool();

        foreach ($this->getTemplate()->getItems() as $id => $item) {
            $cell = $item->createHeaderCell($this, $criteria, $direction);

            $cell->setColumnId($id);
            $this->headerCells[$id] = $cell;

            $row->getChildNodes()->addCell($cell);
        }

        return $this;
    }
}