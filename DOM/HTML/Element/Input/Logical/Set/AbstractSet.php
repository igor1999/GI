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
namespace GI\DOM\HTML\Element\Input\Logical\Set;

use GI\DOM\HTML\Element\Div\FloatingLayout\Layout;

use GI\ClientContents\Selection\Item\ItemInterface as OptionsItemInterface;
use GI\DOM\HTML\Element\Input\Logical\BoolInputInterface;
use GI\DOM\HTML\Element\Input\Logical\CheckboxInterface as CheckboxControlInterface;
use GI\DOM\HTML\Element\Input\Logical\RadioInterface as RadioControlInterface;
use GI\DOM\HTML\Element\TextContainer\Label\LabelInterface;

abstract class AbstractSet extends Layout implements SetInterface
{
    const ID_SEPARATOR = '-';


    /**
     * @var array
     */
    private $commonName = [];

    /**
     * @var string
     */
    private $idPrefix = '';

    /**
     * @var bool
     */
    private $controlBefore = true;


    /**
     * AbstractSet constructor.
     * @param array $commonName
     * @throws \Exception
     */
    public function __construct(array $commonName)
    {
        parent::__construct();

        $this->commonName = $commonName;
    }

    /**
     * @return array
     */
    public function getCommonName()
    {
        return $this->commonName;
    }

    /**
     * @return string
     */
    public function getIdPrefix()
    {
        return $this->idPrefix;
    }

    /**
     * @param string $idPrefix
     * @return static
     */
    public function setIdPrefix(string $idPrefix)
    {
        $this->idPrefix = $idPrefix;

        return $this;
    }

    /**
     * @return bool
     */
    public function isControlBefore()
    {
        return $this->controlBefore;
    }

    /**
     * @param bool $controlBefore
     * @return static
     */
    public function setControlBefore(bool $controlBefore)
    {
        $this->controlBefore = $controlBefore;

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function create()
    {
        $this->build($this->getOptions()->getLength(), 2);

        foreach (array_values($this->getOptions()->getItems()) as $index => $item) {
            $control = $this->getControl($item);
            $label   = $this->getLabel($control, $item);

            if ($this->controlBefore) {
                $this->set($index, 0, $control)->set($index, 1, $label);
            } else {
                $this->set($index, 0, $label)->set($index, 1, $control);
            }
        }

        return $this;
    }

    /**
     * @param OptionsItemInterface $item
     * @return BoolInputInterface
     * @throws \Exception
     */
    protected function getControl(OptionsItemInterface $item)
    {
        $control = $this->createControl($item);

        $control->getName()->setItems($this->commonName);
        if ($this->getOptions()->isMulti()) {
            $control->getName()->add('');
        }

        if (empty($this->idPrefix)) {
            $control->getAttributes()->setId(spl_object_hash($control));
        } else{
            $control->getAttributes()->setId($this->idPrefix . static::ID_SEPARATOR . $item->getValue());
        }

        return $control;
    }

    /**
     * @param OptionsItemInterface $item
     * @return BoolInputInterface
     */
    protected function createControl(OptionsItemInterface $item)
    {
        return $this->getOptions()->isMulti() ? $this->createMultiControl($item) : $this->createSingleControl($item);
    }

    /**
     * @param OptionsItemInterface $item
     * @return CheckboxControlInterface
     */
    protected function createMultiControl(OptionsItemInterface $item)
    {
        return $this->giGetDOMFactory()->getInputFactory()->createCheckbox([], $item->getValue(), $item->isSelected());
    }

    /**
     * @param OptionsItemInterface $item
     * @return RadioControlInterface
     */
    protected function createSingleControl(OptionsItemInterface $item)
    {
        return $this->giGetDOMFactory()->getInputFactory()->createRadio([], $item->getValue(), $item->isSelected());
    }

    /**
     * @param BoolInputInterface $control
     * @param OptionsItemInterface $item
     * @return LabelInterface
     */
    protected function getLabel(BoolInputInterface $control, OptionsItemInterface $item)
    {
        $label = $this->createLabel($item);

        $label->getAttributes()->setFor($control->getAttributes()->getId());

        return $label;
    }

    /**
     * @param OptionsItemInterface $item
     * @return LabelInterface
     */
    protected function createLabel(OptionsItemInterface $item)
    {
        return $this->giGetDOMFactory()->createLabel($item->getText());
    }
}