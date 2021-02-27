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
namespace GI\Component\Menu\View\Builder\Option\Content;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Component\Menu\View\Builder\WidgetAwareTrait;

use GI\ClientContents\Menu\Option\OptionInterface;
use GI\Component\Menu\View\WidgetInterface;
use GI\DOM\HTML\Element\Div\DivInterface;

class Content implements ContentInterface
{
    use ServiceLocatorAwareTrait, WidgetAwareTrait;


    const OPTION_LOCAL_ID_ATTRIBUTE = 'option-local-id';

    const OPTION_CONTAINER_ID_ATTRIBUTE = 'option-container-id';

    const OPTION_ID_ATTRIBUTE       = 'option-id';

    const OPTION_LEVEL_ATTRIBUTE    = 'option-level';

    const OPTION_DISABLED_ATTRIBUTE = 'option-disabled';


    const CLASS_OPTION_DISABLED           = 'gi-option-disabled';

    const CLASS_OPTION_SELECTED           = 'gi-option-selected';

    const CLASS_OPTION_VERTICAL_POINTER   = 'gi-option-vertical-pointer';

    const CLASS_OPTION_HORIZONTAL_POINTER = 'gi-option-horizontal-pointer';


    /**
     * OptionContent constructor.
     * @param WidgetInterface $widget
     */
    public function __construct(WidgetInterface $widget)
    {
        $this->setWidget($widget);
    }

    /**
     * @param OptionInterface $model
     * @param int $level
     * @return DivInterface
     * @throws \Exception
     */
    public function buildOptionContent(OptionInterface $model, int $level)
    {
        $option = $this->giGetDOMFactory()->createDiv();
        $option->getStyle()->setCursorToPointer();

        $option->getAttributes()
            ->setDataAttribute(static::OPTION_LOCAL_ID_ATTRIBUTE, $model->getLocalID())
            ->setDataAttribute(static::OPTION_ID_ATTRIBUTE, $model->getGlobalID())
            ->setDataAttribute(static::OPTION_CONTAINER_ID_ATTRIBUTE, $model->getContainer()->getID())
            ->setDataAttribute(static::OPTION_LEVEL_ATTRIBUTE, $level);

        if ($model->isDisabled()) {
            $option->getAttributes()->setDataAttribute(static::OPTION_DISABLED_ATTRIBUTE, 1);
            $option->getClasses()->add(static::CLASS_OPTION_DISABLED);
        }

        if ($model->isSelected()) {
            $option->getClasses()->add(static::CLASS_OPTION_SELECTED);
        }

        if ($model->hasPopup()) {
            $class = $this->isMenuBar($level)
                ? static::CLASS_OPTION_HORIZONTAL_POINTER
                : static::CLASS_OPTION_VERTICAL_POINTER;

            $option->getClasses()->add($class);
        }

        $link = $this->giGetDOMFactory()->createHyperlink($model->getLink(), $model->getTitle());
        if ($model->hasTarget()) {
            $link->setTarget($model->getTarget());
        }
        $option->getChildNodes()->set($link);

        return $option;
    }
}