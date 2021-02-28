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
namespace GI\Component\Switcher\Base\View;

use GI\Component\Base\View\Widget\AbstractWidget;
use GI\Component\Switcher\Base\View\Context\Context;

use GI\ClientContents\Selection\Single\SingleInterface as SelectionInterface;
use GI\ClientContents\Selection\Item\ItemInterface as SelectionItemInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\Component\Switcher\Base\View\Context\ContextInterface;

class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS  = 'gi-switcher';

    const CLIENT_CSS = self::CLIENT_JS;


    const VALUE_ATTRIBUTE    = 'value';

    const SELECTED_ATTRIBUTE = 'selected';


    const ATTRIBUTE_IS_ALLOW_OFF = 'is-allow-off';


    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var array
     */
    private $name;

    /**
     * @var SelectionInterface
     */
    private $selection;

    /**
     * @var LayoutInterface
     */
    private $container;

    /**
     * @var HiddenInterface
     */
    private $selectionHolder;


    /**
     * Widget constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->resourceRenderer = $this->giGetDi(
            ResourceRendererInterface::class, ResourceRenderer::class
        );

        $this->context = $this->giGetDi(ContextInterface::class, Context::class);
    }

    /**
     * @return ResourceRendererInterface
     */
    protected function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @return ContextInterface
     */
    protected function getContext()
    {
        return $this->context;
    }

     /**
     * @return array
     */
    protected function getName()
    {
        return $this->name;
    }

    /**
     * @param array $name
     * @return static
     */
    public function setName(array $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return SelectionInterface
     */
    protected function getSelection()
    {
        return $this->selection;
    }

    /**
     * @param SelectionInterface $selection
     * @return static
     */
    public function setSelection(SelectionInterface $selection)
    {
        $this->selection = $selection;

        return $this;
    }

    /**
     * @return LayoutInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return HiddenInterface
     */
    public function getSelectionHolder()
    {
        return $this->selectionHolder;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $this->getServerDataList()->set(static::ATTRIBUTE_IS_ALLOW_OFF, (int)$this->getContext()->isAllowOff());

        $this->container->build($this->getRowsNumber(), $this->getColumnsNumber());

        $this->fillContainer();

        return $this;
    }

    /**
     * @return int
     */
    protected function getSize2()
    {
        return (int)ceil($this->getSelection()->getLength() / $this->getContext()->getLines());
    }

    /**
     * @return int
     */
    protected function getRowsNumber()
    {
        return $this->getContext()->isHorizontal() ? $this->getContext()->getLines() : $this->getSize2();
    }

    /**
     * @return int
     */
    protected function getColumnsNumber()
    {
        return $this->getContext()->isHorizontal() ? $this->getSize2() : $this->getContext()->getLines();
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function fillContainer()
    {
        $columnsNumber = $this->getColumnsNumber();

        foreach (array_values($this->getSelection()->getItems()) as $index => $item) {
            $row    = (int)floor($index / $columnsNumber);
            $column = $index % $columnsNumber;

            $this->container->set($row, $column, $this->createOption($item));
        }

        return $this;
    }

    /**
     * @param SelectionItemInterface $item
     * @return DivInterface
     * @throws \Exception
     */
    protected function createOption(SelectionItemInterface $item)
    {
        $option = $this->giGetDOMFactory()->createDiv();

        $option->getChildNodes()->set($item->getText());

        $option->getAttributes()
            ->setDataAttribute(static::VALUE_ATTRIBUTE, $item->getValue())
            ->setDataAttribute(static::SELECTED_ATTRIBUTE, (int)$item->isSelected());

        return $option;
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
     * @render
     * @gi-id selection-holder
     * @return HiddenInterface
     */
    protected function createSelectionHolder()
    {
        $this->selectionHolder = $this->giGetDOMFactory()->getInputFactory()->createHidden(
            $this->name, $this->getSelection()->getSelectedValue()
        );

        return $this->selectionHolder;
    }
}