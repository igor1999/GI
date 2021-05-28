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
namespace GI\DOM\HTML\Element\Select;

use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\Select\Option\Option;
use GI\DOM\HTML\Element\Select\Items\Items;

use GI\ClientContents\Selection\ImmutableInterface as SelectionInterface;
use GI\DOM\HTML\Element\Select\Items\ItemsInterface;

class Select extends ContainerElement implements SelectInterface
{
    const TAG = 'select';


    /**
     * @var ItemsInterface
     */
    private $childNodes;


    /**
     * Select constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);
    }

    /**
     * @return ItemsInterface
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createChildNodes()
    {
        $this->childNodes = $this->getGiServiceLocator()->getDependency(ItemsInterface::class, Items::class);

        return $this;
    }

    /**
     * @param int $size
     * @return static
     */
    public function setSize(int $size)
    {
        $this->getAttributes()->setSize((int)$size);

        return $this;
    }

    /**
     * @param bool $multiple
     * @return static
     */
    public function setMultiple(bool $multiple)
    {
        $this->getAttributes()->setMultiple((bool)$multiple);

        return $this;
    }

    /**
     * @param bool $disabled
     * @return static
     */
    public function setDisabled(bool $disabled)
    {
        $this->getAttributes()->setDisabled((bool)$disabled);

        return $this;
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function getValue()
    {
        $options = $this->getChildNodes()->getOptions();

        $f = function (Option $option)
        {
            return $option->getAttributes()->isSelected();
        };
        $options = array_filter($options, $f);

        $f = function (Option $option)
        {
            return $option->getAttributes()->getValue();
        };
        $values = array_map($f, $options);

        if (!$this->getAttributes()->isMultiple()) {
            $result = empty($values)
                ? $this->getChildNodes()->getFirst()->getAttributes()->getValue()
                : array_shift($values);
        } else {
            $result = $values;
        }

        return $result;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value)
    {
        $options = $this->getChildNodes()->getOptions();

        $f = function (Option $option)
        {
            return $option->setSelected(false);
        };
        $options = array_map($f, $options);

        $isMultiple = $this->getAttributes()->isMultiple();

        if ($isMultiple && !is_array($value)) {
            $value = [$value];
        }

        foreach ($options as $option) {
            $optionValue = $option->getAttributes()->getValue();

            if ($isMultiple && in_array($optionValue, $value)) {
                $option->setSelected(true);
            } elseif (!$isMultiple && $optionValue == $value) {
                $option->setSelected(true);
                break;
            }
        }

        return $this;
    }

    /**
     * @param array $contents
     * @return static
     */
    public function build(array $contents)
    {
        $this->getChildNodes()->clean();

        foreach ($contents as $value => $text) {
            $this->getChildNodes()->createAndAddOption($value, $text);
        }

        return $this;
    }

    /**
     * @param int $first
     * @param int $last
     * @param int $step
     * @param \Closure|null $textProcessor
     * @return static
     * @throws \Exception
     */
    public function buildSequence(int $first, int $last, int $step = 1, \Closure $textProcessor = null)
    {
        $this->getChildNodes()->clean();

        if ($step <= 0) {
            $this->getGiServiceLocator()->throwInvalidMinimumException('Step', $step, 1);
        }

        for ($value = (int)$first; $value <= (int)$last; $value += $step) {
            $text = ($textProcessor instanceof \Closure) ? call_user_func($textProcessor, $value) : $value;

            $this->getChildNodes()->createAndAddOption($value, $text);
        }

        return $this;
    }

    /**
     * @param array $values
     * @param \Closure|null $textProcessor
     * @return static
     */
    public function buildByValues(array $values, \Closure $textProcessor = null)
    {
        $this->getChildNodes()->clean();

        foreach ($values as $value) {
            $text = ($textProcessor instanceof \Closure) ? call_user_func($textProcessor, $value) : $value;

            $this->getChildNodes()->createAndAddOption($value, $text);
        }

        return $this;
    }

    /**
     * @param SelectionInterface $selection
     * @return static
     */
    public function buildBySelection(SelectionInterface $selection)
    {
        $this->getChildNodes()->clean();

        foreach ($selection->getItems() as $item) {
            $this->getChildNodes()->createAndAddOption($item->getValue(), $item->getText(), $item->isSelected());
        }

        $this->setMultiple($selection->isMulti());

        return $this;
    }
}