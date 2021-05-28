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
namespace GI\Component\Autocomplete\View;

use GI\Component\Base\View\Widget\AbstractWidget;

use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Input\Text\TextInterface;
use GI\DOM\HTML\Element\Lists\UL\ULInterface;
use GI\Component\Autocomplete\Context\ContextInterface;

/**
 * Class Widget
 * @package GI\Component\Autocomplete\View
 *
 * @method array getName()
 * @method WidgetInterface setName(array $name)
 * @method getValue()
 * @method WidgetInterface setValue($value)
 * @method ContextInterface getContext()
 * @method WidgetInterface setContext(ContextInterface $contents)
 */
class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS        = 'gi-autocomplete';

    const CLIENT_CSS       = self::CLIENT_JS;

    const JS_CLASS_ELEMENT = 'textbox';


    const ATTRIBUTE_DATA_NAME = 'name';

    const ATTRIBUTE_URI       = 'uri';


    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var TextInterface
     */
    private $textbox;

    /**
     * @var DivInterface
     */
    private $listContainer;

    /**
     * @var ULInterface
     */
    private $list;


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
        $this->getServerDataList()->set(static::ATTRIBUTE_URI, $this->getContext()->getUri());

        $this->listContainer->getChildNodes()->set($this->list);

        return $this;
    }

    /**
     * @render
     * @gi-id textbox
     * @return TextInterface
     * @throws \Exception
     */
    protected function getTextbox()
    {
        if (!($this->textbox instanceof TextInterface)) {
            $this->textbox = $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createText($this->getName(), $this->getValue());

            $this->textbox->getAttributes()->setAutocompleteToOff();
            $this->textbox->setPlaceholder($this->getContext()->getPlaceholder());
            $this->textbox->getAttributes()->setDataAttribute(
                static::ATTRIBUTE_DATA_NAME, $this->getContext()->getDataName()
            );
        }

        return $this->textbox;
    }

    /**
     * @render
     * @gi-id list-container
     * @return DivInterface
     */
    protected function getListContainer()
    {
        if (!($this->listContainer instanceof DivInterface)) {
            $this->listContainer = $this->getGiServiceLocator()->getDOMFactory()->createDiv();
            $this->listContainer->hide()->getStyle()->setPositionToAbsolute();
        }

        return $this->listContainer;
    }

    /**
     * @gi-id list
     * @return ULInterface
     */
    protected function getList()
    {
        if (!($this->list instanceof ULInterface)) {
            $this->list = $this->getGiServiceLocator()->getDOMFactory()->createUL();
        }

        return $this->list;
    }
}