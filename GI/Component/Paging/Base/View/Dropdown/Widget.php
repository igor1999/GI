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
namespace GI\Component\Paging\Base\View\Dropdown;

use GI\Component\Paging\Base\View\Base\AbstractWidget;
use GI\Component\Paging\I18n\Glossary;

use GI\DOM\HTML\Element\Select\SelectInterface;
use GI\Component\Paging\I18n\GlossaryInterface;

class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS  = 'gi-paging-dropdown';

    const CLIENT_CSS = self::CLIENT_JS;


    const ENTRY_TEMPLATE = 'Page Nr. %s';


    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var SelectInterface
     */
    private $pagesSelect;


    /**
     * Widget constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->resourceRenderer = $this->getGiServiceLocator()->getDependency(
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
            ->set(0, 2, $this->pagesSelect)
            ->set(0, 3, $this->getNaviToNext())
            ->set(0, 4, $this->getNaviToLast());

        return $this;
    }

    /**
     * @gi-id pages-select
     * @return SelectInterface
     * @throws \Exception
     */
    protected function getPagesSelect()
    {
        if (!($this->pagesSelect instanceof SelectInterface)) {
            $this->pagesSelect = $this->getGiServiceLocator()->getDOMFactory()->createSelect();

            $template = $this->getGiServiceLocator()->translate(
                GlossaryInterface::class, Glossary::class,static::ENTRY_TEMPLATE
            );

            $f = function($value) use ($template)
            {
                return sprintf($template, $value);
            };

            $total = $this->getPagingModel()->getPagesTotal();

            $this->pagesSelect->buildSequence(1, $total,1, $f);

            $this->pagesSelect->setValue($this->getPagingModel()->getSelectedPage());
        }

        return $this->pagesSelect;
    }
}