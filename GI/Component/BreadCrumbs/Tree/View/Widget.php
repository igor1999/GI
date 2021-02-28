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
namespace GI\Component\BreadCrumbs\Tree\View;

use GI\Component\BreadCrumbs\Base\View\AbstractWidget;
use GI\Component\BreadCrumbs\Tree\View\Context\Context;

use GI\DOM\HTML\Element\Div\DivInterface;
use GI\Component\BreadCrumbs\Tree\View\Context\ContextInterface;

class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_CSS = 'gi-bread-crumbs-tree';


    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var DivInterface
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
     * @return ResourceRendererInterface
     */
    protected function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @return DivInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $linkedList = $this->giGetDOMFactory()->createLinkedList($this->getNodes());

        $this->container->getChildNodes()->set($linkedList);

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
}