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
namespace GI\Component\Paging\Base\View\Chain;

use GI\Component\Paging\Base\View\Base\AbstractWidget;

use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\ClientContents\Paging\Base\ShowedPages\ShowedPagesInterface;

class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS  = 'gi-paging-chain';

    const CLIENT_CSS = self::CLIENT_JS;


    const GI_ID_ITEM      = 'item';

    const GI_ID_SEPARATOR = 'separator';


    const CLASS_SELECTED_ITEM = 'gi-selected-item';


    const SEPARATOR = '...';


    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var LayoutInterface
     */
    private $pagesContainer;


    /**
     * Widget constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->resourceRenderer = $this->giGetDi(
            ResourceRendererInterface::class, ResourceRenderer::class
        );
    }

    /**
     * @return ResourceRendererInterface
     */
    protected function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        parent::build();

        $this->getContainer()->build(1, 6)
            ->set(0, 0, $this->getNaviToFirst())
            ->set(0, 1, $this->getNaviToPrev())
            ->set(0, 2, $this->pagesContainer)
            ->set(0, 3, $this->getNaviToNext())
            ->set(0, 4, $this->getNaviToLast());

        return $this;
    }

    /**
     * @gi-id pages-container
     * @return LayoutInterface
     * @throws \Exception
     */
    protected function getPagesContainer()
    {
        if (!($this->pagesContainer instanceof LayoutInterface)) {
            $this->pagesContainer = $this->giGetDOMFactory()->createLayout();

            $this->buildPagesContents();
        }

        return $this->pagesContainer;
    }

    /**
     * @param ShowedPagesInterface|null $showedPages
     * @return static
     * @throws \Exception
     */
    protected function buildPagesContents(ShowedPagesInterface $showedPages = null)
    {
        if (!($showedPages instanceof ShowedPagesInterface)) {
            $showedPages = $this->getPagingModel()->getShowedPages();
        }

        for ($i = $showedPages->getFirstPage(); $i <= $showedPages->getLastPage(); $i++) {
            if ($i == $this->getViewModel()->getSelectedPage()) {
                $content = $this->giGetDOMFactory()->createSpan($i);
                $class   = static::CLASS_SELECTED_ITEM;
            } else {
                $content = $this->giGetDOMFactory()->createHyperlink('', $i)->setHrefToMock();
                $this->addClientAttributes($content, '');
                $content->getAttributes()->setDataAttribute(static::NAVI_TARGET_PAGE_ATTRIBUTE, $i);
                $class = '';
            }

            $cell = $this->giGetDOMFactory()->createFloatLeft();
            $this->addClientAttributes($cell, static::GI_ID_ITEM);
            $cell->getChildNodes()->set($content);
            $cell->getClasses()->add($class);
            $this->pagesContainer->getChildNodes()->addCell(0, $cell);
        }

        $next = $showedPages->getNext();
        if ($next instanceof ShowedPagesInterface) {
            $content = $this->giGetDOMFactory()->createSpan(static::SEPARATOR);

            $cell = $this->giGetDOMFactory()->createFloatLeft();
            $this->addClientAttributes($cell, static::GI_ID_SEPARATOR);
            $cell->getChildNodes()->set($content);
            $this->pagesContainer->getChildNodes()->addCell(0, $cell);

            $this->buildPagesContents($next);
        }

        return $this;
    }
}