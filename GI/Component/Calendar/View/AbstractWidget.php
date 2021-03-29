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
namespace GI\Component\Calendar\View;

use GI\Component\Base\View\Widget\AbstractWidget as Base;
use GI\Component\Calendar\I18n\Glossary;

use GI\Calendar\Day\DayInterface;
use GI\Component\Calendar\ViewModel\ViewModelInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Form\Layouts\Form\FormInterface as FormLayoutInterface;
use GI\DOM\HTML\Element\Input\Button\ButtonInterface;
use GI\DOM\HTML\Element\Input\DateTime\MonthInterface as InputMonthInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\Calendar\Month\MonthInterface;
use GI\DOM\HTML\Element\Table\TableInterface;
use GI\Component\Calendar\I18n\GlossaryInterface;

/**
 * Class AbstractWidget
 * @package GI\Component\Calendar\View
 *
 * @method ViewModelInterface getViewModel()
 * @method WidgetInterface setViewModel(ViewModelInterface $viewModel)
 */
abstract class AbstractWidget extends Base implements WidgetInterface
{
    use ContentsTrait;


    const CLIENT_CSS = 'gi-calendar';

    const CLIENT_JS  = self::CLIENT_CSS;


    const CLASS_INACTIVE_CONTENT_CELL = 'gi-cell-inactive';


    const GI_ID_CONTENT_HEAD_ROW = 'content-head-row';


    const RELATION_TO_NAVI = 'navi';


    /**
     * @return ResourceRendererInterface
     */
    abstract protected function getResourceRenderer();

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $this->navigationForm->build(1 , 2)
            ->set(0, 0, $this->navigationMonth)
            ->set(0, 1, $this->navigationSubmitButton);

        $this->container->getChildNodes()->set([$this->navigationForm, $this->contentTable]);

        return $this;
    }

    /**
     * @render
     * @gi-id container
     * @return DivInterface
     */
    protected function createContainer()
    {
        $this->container = $this->giGetDOMFactory()->createDiv();

        return $this->container;
    }

    /**
     * @gi-id navigation-form
     * @return FormLayoutInterface
     */
    protected function createNavigationForm()
    {
        $this->navigationForm = $this->giGetDOMFactory()->createFormLayout();

        $this->addCommonFormId($this->navigationForm);

        return $this->navigationForm;
    }

    /**
     * @gi-id navigation-month
     * @return InputMonthInterface
     * @throws \Exception
     */
    protected function createNavigationMonth()
    {
        $this->navigationMonth = $this->giGetDOMFactory()->getInputFactory()->createMonth(
            $this->getViewModel()->getMonthName(),
             $this->getViewModel()->getMonthAsDateTime()->format('Y-m')
        );

        $this->addFormAttribute($this->navigationMonth);

        return $this->navigationMonth;
    }

    /**
     * @gi-id navigation-button
     * @return ButtonInterface
     */
    protected function createNavigationSubmitButton()
    {
        $this->navigationSubmitButton = $this->giGetDOMFactory()->getInputFactory()->createButton(
            [], $this->giTranslate(GlossaryInterface::class, Glossary::class, 'show!')
        );

        return $this->navigationSubmitButton;
    }

    /**
     * @gi-id content-table
     * @return TableInterface
     * @throws \Exception
     */
    protected function createContentTable()
    {
        $this->contentTable = $this->giGetDOMFactory()->createTable();

        $this->createContentHeadRow()->fillContentTable();

        return $this->contentTable;
    }

    /**
     * @return static
     */
    protected function createContentHeadRow()
    {
        $this->contentHeadRow = $this->giGetDOMFactory()->createTR();

        foreach ($this->giGetCalendarFactory()->getWeek()->getDays()->getItems() as $day) {
            $this->contentHeadRow->getChildNodes()->addCell($this->createContentHeadCell($day));
        }

        return $this;
    }

    /**
     * @param DayInterface $day
     * @return TDInterface
     */
    protected function createContentHeadCell(DayInterface $day)
    {
        return $this->giGetDOMFactory()->createTD($day->getShortNameInWeek());
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function fillContentTable()
    {
        $this->contentTable->getChildNodes()->clean()->addRow($this->contentHeadRow);

        $month = $this->giGetCalendarFactory()->getMonth($this->getViewModel()->getMonthAsDateTime());

        foreach ($month->getWeeks()->getItems() as $week) {
            $row = $this->giGetDOMFactory()->createTR();
            $this->contentTable->getChildNodes()->addRow($row);
            foreach ($week->getDays()->getItems() as $day) {
                $row->getChildNodes()->addCell($this->createContentCell($month, $day));
            }
        }

        $this->addClientAttributes($this->contentHeadRow, static::GI_ID_CONTENT_HEAD_ROW);

        return $this;
    }

    /**
     * @param MonthInterface $navigationMonth
     * @param DayInterface $day
     * @return TDInterface
     * @throws \Exception
     */
    protected function createContentCell(MonthInterface $navigationMonth, DayInterface $day)
    {
        $cell = $this->giGetDOMFactory()->createTD($day->getNumberInMonth());
        $cell->getAttributes()->setDataAttribute('date', $day->getDate()->format('Y-m-d'));

        if ($day->getMonth()->getNumber() != $navigationMonth->getNumber()) {
            $cell->getClasses()->add(static::CLASS_INACTIVE_CONTENT_CELL);
        }

        $this->configContentCell($day, $cell);

        return $cell;
    }

    /**
     * @param DayInterface $day
     * @param TDInterface $cell
     * @return static
     */
    abstract protected function configContentCell(DayInterface $day, TDInterface $cell);
}