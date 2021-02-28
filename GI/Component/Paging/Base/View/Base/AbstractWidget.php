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
namespace GI\Component\Paging\Base\View\Base;

use GI\Component\Base\View\Widget\AbstractWidget as Base;
use GI\Component\Paging\I18n\Glossary;

use GI\Component\Paging\I18n\GlossaryInterface;
use GI\DOM\HTML\Element\Form\FormInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Select\SelectInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Div\DivInterface;

abstract class AbstractWidget extends Base implements WidgetInterface
{
    use ContentsTrait;


    const CLIENT_CSS = 'gi-paging-base';


    const DESCRIPTION_FOR_ENTRIES_TOTAL = 'entries %s - %s from totally %s';


    const TITLE_FOR_SIZES_SELECT = '%s entries pro page';

    const TITLE_FOR_FIRST_NAVI   = 'first';

    const TITLE_FOR_PREV_NAVI    = 'previous';

    const TITLE_FOR_NEXT_NAVI    = 'next';

    const TITLE_FOR_LAST_NAVI    = 'last';


    const CLASS_NAVI_INACTIVE = 'gi-navi-inactive';


    const NAVI_TARGET_PAGE_ATTRIBUTE = 'target-page';

    const NAVI_ACTIVITY_ATTRIBUTE    = 'active';


    /**
     * @return ResourceRendererInterface
     */
    abstract protected function getResourceRenderer();

    /**
     * @return string
     */
    public function getDescriptionForEntriesTotal()
    {
        return sprintf(
            $this->giTranslate(
                GlossaryInterface::class, Glossary::class, static::DESCRIPTION_FOR_ENTRIES_TOTAL
            ),
            $this->getPagingModel()->getFirstShowedEntry(),
            $this->getPagingModel()->getLastShowedEntry(),
            $this->getPagingModel()->getEntriesTotal()
        );
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $this->form->getChildNodes()->set([$this->selectedPageHidden]);

        return $this;
    }

    /**
     * @render
     * @gi-id form
     * @return FormInterface
     */
    protected function createForm()
    {
        $this->form = $this->giGetDOMFactory()->createForm();

        $this->addCommonFormId($this->form);

        return $this->form;
    }

    /**
     * @render
     * @gi-id container
     * @return LayoutInterface
     */
    protected function createContainer()
    {
        $this->container = $this->giGetDOMFactory()->createLayout();

        return $this->container;
    }

    /**
     * @gi-id sizes-select
     * @return SelectInterface
     * @throws \Exception
     */
    protected function createSizesSelect()
    {
        $template = $this->giTranslate(
            GlossaryInterface::class, Glossary::class, static::TITLE_FOR_SIZES_SELECT
        );
        $f = function($value) use ($template)
        {
              return sprintf($template, $value);
        };
        $this->sizesSelect = $this->giGetDOMFactory()->createSelect()->buildByValues(
            $this->getPagingModel()->getContext()->getSizes()->getItems(), $f
        );

        $this->sizesSelect->getName()->setItems($this->getViewModel()->getEntriesProPageName());

        $this->sizesSelect->setValue($this->getPagingModel()->getEntriesProPage());

        $this->addFormAttribute($this->sizesSelect);

        return $this->sizesSelect;
    }

    /**
     * @gi-id selected-page-hidden
     * @return HiddenInterface
     */
    protected function createSelectedPageHidden()
    {
        $this->selectedPageHidden = $this->giGetDOMFactory()->getInputFactory()->createHidden(
            $this->getViewModel()->getSelectedPageName(), $this->getPagingModel()->getSelectedPage()
        );

        $this->addFormAttribute($this->selectedPageHidden);

        return $this->selectedPageHidden;
    }

    /**
     * @gi-id navi-to-first
     * @return DivInterface
     * @throws \Exception
     */
    protected function createNaviToFirst()
    {
        $this->naviToFirst = $this->createNavi(
            static::TITLE_FOR_FIRST_NAVI,
            1,
            $this->getPagingModel()->needNaviFirst()
        );

        return $this->naviToFirst;
    }

    /**
     * @gi-id navi-to-prev
     * @return DivInterface
     * @throws \Exception
     */
    protected function createNaviToPrev()
    {
        $this->naviToPrev = $this->createNavi(
            static::TITLE_FOR_PREV_NAVI,
            $this->getPagingModel()->getSelectedPage() - 1,
            $this->getPagingModel()->needNaviPrevious()
        );

        return $this->naviToPrev;
    }

    /**
     * @gi-id navi-to-next
     * @return DivInterface
     * @throws \Exception
     */
    protected function createNaviToNext()
    {
        $this->naviToNext = $this->createNavi(
            static::TITLE_FOR_NEXT_NAVI,
            $this->getPagingModel()->getSelectedPage() + 1,
            $this->getPagingModel()->needNaviNext()
        );

        return $this->naviToNext;
    }

    /**
     * @gi-id navi-to-last
     * @return DivInterface
     * @throws \Exception
     */
    protected function createNaviToLast()
    {
        $this->naviToLast = $this->createNavi(
            static::TITLE_FOR_LAST_NAVI,
            $this->getPagingModel()->getPagesTotal(),
            $this->getPagingModel()->needNaviLast()
        );

        return $this->naviToLast;
    }

    /**
     * @param string $title
     * @param int $page
     * @param bool $activity
     * @return DivInterface
     * @throws \Exception
     */
    protected function createNavi(string $title, int $page, bool $activity)
    {
        $navi = $this->giGetDOMFactory()->createDiv();

        $content = $this->giGetDOMFactory()->createHyperlink(
            '', $this->giTranslate(GlossaryInterface::class, Glossary::class, $title)
        )->setHrefToMock();
        $navi->getChildNodes()->set($content);

        $navi->getAttributes()->setDataAttribute(static::NAVI_TARGET_PAGE_ATTRIBUTE, $page);

        if ($activity) {
            $navi->getAttributes()->setDataAttribute(static::NAVI_ACTIVITY_ATTRIBUTE, 1);
        } else {
            $navi->getAttributes()->setDataAttribute(static::NAVI_ACTIVITY_ATTRIBUTE, 0);
            $navi->getClasses()->add(static::CLASS_NAVI_INACTIVE);
        }

        return $navi;
    }
}