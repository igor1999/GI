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
use GI\DOM\HTML\Element\Table\Row\TRInterface;
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
    const CLIENT_CSS = 'gi-calendar';

    const CLIENT_JS  = self::CLIENT_CSS;


    const CLASS_INACTIVE_CONTENT_CELL = 'gi-cell-inactive';


    const GI_ID_CONTENT_HEAD_ROW = 'content-head-row';


    const RELATION_TO_NAVI = 'navi';


    /**
     * @var DivInterface
     */
    private $container;

    /**
     * @var FormLayoutInterface
     */
    private $navigationForm;

    /**
     * @var MonthInterface
     */
    private $navigationMonth;

    /**
     * @var ButtonInterface
     */
    private $navigationSubmitButton;

    /**
     * @var TableInterface
     */
    private $contentTable;

    /**
     * @var TRInterface
     */
    private $contentHeadRow;


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
    protected function getContainer()
    {
        if (!($this->container instanceof DivInterface)) {
            $this->container = $this->getGiServiceLocator()->getDOMFactory()->createDiv();
        }

        return $this->container;
    }

    /**
     * @gi-id navigation-form
     * @return FormLayoutInterface
     */
    protected function getNavigationForm()
    {
        if (!($this->navigationForm instanceof FormLayoutInterface)) {
            $this->navigationForm = $this->getGiServiceLocator()->getDOMFactory()->createFormLayout();

            $this->addCommonFormId($this->navigationForm);
        }

        return $this->navigationForm;
    }

    /**
     * @gi-id navigation-month
     * @return InputMonthInterface
     * @throws \Exception
     */
    protected function getNavigationMonth()
    {
        if (!($this->navigationMonth instanceof InputMonthInterface)) {
            $this->navigationMonth = $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createMonth(
                $this->getViewModel()->getMonthName(),
                $this->getViewModel()->getMonthAsDateTime()->format('Y-m')
            );

            $this->addFormAttribute($this->navigationMonth);
        }

        return $this->navigationMonth;
    }

    /**
     * @gi-id navigation-button
     * @return ButtonInterface
     */
    protected function getNavigationSubmitButton()
    {
        if (!($this->navigationSubmitButton instanceof ButtonInterface)) {
            $title = $this->getGiServiceLocator()->translate(GlossaryInterface::class, Glossary::class, 'show!');

            $this->navigationSubmitButton = $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createButton([], $title);
        }

        return $this->navigationSubmitButton;
    }

    /**
     * @gi-id content-table
     * @return TableInterface
     * @throws \Exception
     */
    protected function getContentTable()
    {
        if (!($this->contentTable instanceof TableInterface)) {
            $this->contentTable = $this->getGiServiceLocator()->getDOMFactory()->createTable();

            $this->createContentHeadRow()->fillContentTable();
        }

        return $this->contentTable;
    }

    /**
     * @return static
     */
    protected function createContentHeadRow()
    {
        $this->contentHeadRow = $this->getGiServiceLocator()->getDOMFactory()->createTR();

        foreach ($this->getGiServiceLocator()->getCalendarFactory()->getWeek()->getDays()->getItems() as $day) {
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
        return $this->getGiServiceLocator()->getDOMFactory()->createTD($day->getShortNameInWeek());
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function fillContentTable()
    {
        $this->contentTable->getChildNodes()->clean()->addRow($this->contentHeadRow);

        $month = $this->getGiServiceLocator()->getCalendarFactory()
            ->getMonth($this->getViewModel()->getMonthAsDateTime());

        foreach ($month->getWeeks()->getItems() as $week) {
            $row = $this->getGiServiceLocator()->getDOMFactory()->createTR();
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
        $cell = $this->getGiServiceLocator()->getDOMFactory()->createTD($day->getNumberInMonth());
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