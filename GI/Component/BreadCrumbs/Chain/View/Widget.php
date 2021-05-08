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
namespace GI\Component\BreadCrumbs\Chain\View;

use GI\Component\BreadCrumbs\Base\View\AbstractWidget;
use GI\Component\BreadCrumbs\Chain\View\Context\Context;

use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\TextContainer\Span\SpanInterface;
use GI\Component\BreadCrumbs\Chain\View\Context\ContextInterface;

class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_CSS = 'gi-bread-crumbs-chain';


    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var LayoutInterface
     */
    private $container;


    /**
     * Widget constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->context = $this->giGetDi(ContextInterface::class, Context::class);

        $this->resourceRenderer = $this->giGetDi(
            ResourceRendererInterface::class, ResourceRenderer::class
        );
    }

    /**
     * @return ContextInterface
     */
    protected function getContext()
    {
        return $this->context;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateContents()
    {
        $this->getContext()->validateProperties();
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
        $length = $this->getBreadCrumbsTrack()->getLength();
        $this->container->build(1, $length);

        $index = 0;
        foreach ($this->getNodes() as $id => $item) {
            $separator = $this->createSeparator($id);

            if ($index < ($length - 1)) {
                $this->container->set(0, $index, [$item, $separator]);
            } else {
                $this->container->set(0, $index, $item);
            }

            $index += 1;
        }

        return $this;
    }

    /**
     * @render
     * @gi-id container
     * @return LayoutInterface
     */
    protected function getContainer()
    {
        if (!($this->container instanceof LayoutInterface)) {
            $this->container = $this->giGetDOMFactory()->createLayout();
        }

        return $this->container;
    }

    /**
     * @param string $id
     * @return SpanInterface
     * @throws \Exception
     */
    protected function createSeparator(string $id)
    {
        $span = $this->giGetDOMFactory()->createSpan();
        $span->getAttributes()->setDataAttribute(static::ATTRIBUTE_NODE_ID, $id);

        $text = $this->giGetDOMFactory()->createTextNode($this->getContext()->getSeparator());
        $text->getTextProcessor()->getEscaper()->setOn(false);

        $span->getChildNodes()->add($text);

        return $span;
    }
}