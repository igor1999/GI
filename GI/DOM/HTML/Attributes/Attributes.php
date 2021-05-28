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
namespace GI\DOM\HTML\Attributes;

use GI\DOM\Base\Attributes\AbstractAttributes;

use GI\Util\TextProcessing\Escaper\HTMLAttribute\EscaperInterface;

/**
 * Class Attributes
 * @package GI\DOM\HTML\Attributes
 *
 * @method string getId()
 * @method AttributesInterface setId(string $id)
 * @method string getType()
 * @method AttributesInterface setType(string $type)
 *
 * @method AttributesInterface setTypeToText()
 * @method AttributesInterface setTypeToButton()
 * @method AttributesInterface setTypeToCheckbox()
 * @method AttributesInterface setTypeToRadio()
 * @method AttributesInterface setTypeToImage()
 * @method AttributesInterface setTypeToReset()
 * @method AttributesInterface setTypeToSubmit()
 * @method AttributesInterface setTypeToFile()
 *
 * @method string getTitle()
 * @method AttributesInterface setTitle(string $title)
 * @method string getHref()
 * @method AttributesInterface setHref(string $href)
 * @method string getAlt()
 * @method AttributesInterface setAlt(string $alt)
 * @method string getSrc()
 * @method AttributesInterface setSrc(string $src)
 * @method string getTarget()
 * @method AttributesInterface setTarget(string $target)
 * @method getValue()
 * @method AttributesInterface setValue($value)
 * @method string getFor()
 * @method AttributesInterface setFor(string $id)
 * @method string getForm()
 * @method AttributesInterface setForm(string $formId)
 * @method bool isDisabled()
 * @method AttributesInterface setDisabled(bool $disabled)
 * @method bool isChecked()
 * @method AttributesInterface setChecked(bool $checked)
 * @method bool isSelected()
 * @method AttributesInterface setSelected(bool $selected)
 * @method isAutocompleteEqualOn()
 * @method isAutocompleteEqualOff()
 * @method AttributesInterface setAutocompleteToOn()
 * @method AttributesInterface setAutocompleteToOff()
 * @method isUnselectableEqualOn()
 * @method isUnselectableEqualOff()
 * @method AttributesInterface setUnselectableToOn()
 * @method AttributesInterface setUnselectableToOff()
 * @method bool isReadonly()
 * @method AttributesInterface setReadonly(bool $readOnly)
 * @method getPlaceholder()
 * @method AttributesInterface setPlaceholder(string $placeholder)
 * @method string getMethod()
 * @method AttributesInterface setMethod(string $method)
 * @method bool isMethodEqualGet()
 * @method AttributesInterface setMethodToGet()
 * @method bool isMethodEqualPost()
 * @method AttributesInterface setMethodToPost()
 * @method AttributesInterface setMethodToPut()
 * @method AttributesInterface setMethodToDelete()
 * @method string getAction()
 * @method AttributesInterface setAction(string $action)
 * @method int getMaxLength()
 * @method AttributesInterface setMaxLength(int $length)
 * @method bool isMultiple()
 * @method AttributesInterface setMultiple(bool $multiple)
 * @method int getSize()
 * @method AttributesInterface setSize(int $size)
 * @method int getColspan()
 * @method AttributesInterface setColspan(int $span)
 * @method int getRowspan()
 * @method AttributesInterface setRowspan(int $span)
 * @method int getCols()
 * @method AttributesInterface setCols(int $cols)
 * @method int getRows()
 * @method AttributesInterface setRows(int $rows)
 */
class Attributes extends AbstractAttributes implements AttributesInterface
{
    /**
     * @var EscaperInterface
     */
    private $escaper;


    /**
     * @return static
     */
    protected function createEscaper()
    {
        $this->escaper = $this->getGiServiceLocator()->getUtilites()->getEscaperFactory()->createHTMLAttribute();

        return $this;
    }

    /**
     * @return EscaperInterface
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public function hasDataAttribute(string $key)
    {
        return $this->has(self::DATA_ATTRIBUTE_PREFIX . $key);
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function getDataAttribute(string $key)
    {
        return $this->get(self::DATA_ATTRIBUTE_PREFIX . $key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return static
     * @throws \Exception
     */
    public function setDataAttribute(string $key, $value)
    {
        $this->set(self::DATA_ATTRIBUTE_PREFIX . $key, $value);

        return $this;
    }
}