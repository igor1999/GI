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

class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS        = 'gi-autocomplete';

    const CLIENT_CSS       = self::CLIENT_JS;

    const JS_CLASS_ELEMENT = 'textbox';


    const ATTRIBUTE_DATA_NAME = 'name';

    const ATTRIBUTE_URI       = 'uri';


    /**
     * @var array
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var ContextInterface
     */
    private $context;

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
        $this->resourceRenderer = $this->giGetDi(
            ResourceRendererInterface::class, ResourceRenderer::class
        );
    }

     /**
     * @return array
     */
    public function getName()
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
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return ContextInterface
     */
    protected function getContext()
    {
        return $this->context;
    }

    /**
     * @param ContextInterface $context
     * @return static
     */
    public function setContext(ContextInterface $context)
    {
        $this->context = $context;

        return $this;
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
    public function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @return TextInterface
     */
    public function getTextbox()
    {
        return $this->textbox;
    }

    /**
     * @return DivInterface
     */
    public function getListContainer()
    {
        return $this->listContainer;
    }

    /**
     * @return ULInterface
     */
    public function getList()
    {
        return $this->list;
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
    protected function createTextbox()
    {
        $this->textbox = $this->giGetDOMFactory()->getInputFactory()->createText($this->name, $this->value);

        $this->textbox->getAttributes()->setAutocompleteToOff();
        $this->textbox->setPlaceholder($this->getContext()->getPlaceholder());
        $this->textbox->getAttributes()->setDataAttribute(
            static::ATTRIBUTE_DATA_NAME, $this->getContext()->getDataName()
        );

        return $this->textbox;
    }

    /**
     * @render
     * @gi-id list-container
     * @return DivInterface
     */
    protected function createListContainer()
    {
        $this->listContainer = $this->giGetDOMFactory()->createDiv();
        $this->listContainer->getStyle()->setDisplayToNone()->setPositionToAbsolute();

        return $this->listContainer;
    }

    /**
     * @gi-id list
     * @return ULInterface
     */
    protected function createList()
    {
        $this->list = $this->giGetDOMFactory()->createUL();

        return $this->list;
    }
}