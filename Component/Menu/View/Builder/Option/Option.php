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
namespace GI\Component\Menu\View\Builder\Option;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Component\Menu\View\Builder\WidgetAwareTrait;

use GI\Component\Menu\View\WidgetInterface;
use GI\DOM\HTML\Element\Lists\Items\LI\LIInterface;
use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Lists\UL\ULInterface;

class Option implements OptionInterface
{
    use ServiceLocatorAwareTrait, WidgetAwareTrait;


    /**
     * Option constructor.
     * @param WidgetInterface $widget
     */
    public function __construct(WidgetInterface $widget)
    {
        $this->setWidget($widget);
    }

    /**
     * @return LIInterface
     * @throws \Exception
     */
    public function buildClearItem()
    {
        $li = $this->giGetDOMFactory()->createLI();
        $this->setClearLIStyle($li);

        return $li;
    }

    /**
     * @param int $level
     * @param DivInterface $optionContent
     * @param ULInterface|null $submenu
     * @return LIInterface
     * @throws \Exception
     */
    public function buildOption(int $level, DivInterface $optionContent, ULInterface $submenu = null)
    {
        if ($this->isMenuBar($level)) {
            $result = $this->buildBarOption($optionContent, $submenu);
        } elseif ($submenu instanceof ULInterface) {
            $result = $this->buildOptionForPopup($optionContent, $submenu);
        } else {
            $result = $this->buildCommonOption($optionContent);
        }

        return $result;
    }

    /**
     * @param DivInterface $optionContent
     * @param ULInterface|null $submenu
     * @return LIInterface
     * @throws \Exception
     */
    protected function buildBarOption(DivInterface $optionContent, ULInterface $submenu = null)
    {
        $result = $this->giGetDOMFactory()->createLI();

        $result->getChildNodes()->set(array_filter([$optionContent, $submenu]));
        $this->setFloatLIStyle($result);

        return $result;
    }

    /**
     * @param DivInterface $optionContent
     * @param ULInterface $submenu
     * @return LIInterface[]
     * @throws \Exception
     */
    protected function buildOptionForPopup(DivInterface $optionContent, ULInterface $submenu)
    {
        $li1 = $this->giGetDOMFactory()->createLI();
        $li1->getChildNodes()->set($optionContent);
        $this->setFloatLIStyle($li1);

        $li2 = $this->giGetDOMFactory()->createLI();
        $li2->getChildNodes()->set($submenu);
        $this->setFloatLIStyle($li2);

        $li3 = $this->giGetDOMFactory()->createLI();
        $this->setClearLIStyle($li3);

        return [$li1, $li2, $li3];
    }

    /**
     * @param DivInterface $optionContent
     * @return LIInterface
     * @throws \Exception
     */
    protected function buildCommonOption(DivInterface $optionContent)
    {
        $result = $this->giGetDOMFactory()->createLI();

        $result->getChildNodes()->set($optionContent);
        $this->setBasicLIStyle($result);

        return $result;
    }

    /**
     * @param LIInterface $li
     * @return static
     * @throws \Exception
     */
    protected function setBasicLIStyle(LIInterface $li)
    {
        $li->getStyle()->setPadding(0)->setMargin(0)->setCursorToDefault()->set('list-style', 'none');

        return $this;
    }

    /**
     * @param LIInterface $li
     * @return static
     * @throws \Exception
     */
    protected function setFloatLIStyle($li)
    {
        $this->setBasicLIStyle($li);
        $li->getStyle()->setFloatToLeft();

        return $this;
    }

    /**
     * @param LIInterface $li
     * @return static
     * @throws \Exception
     */
    protected function setClearLIStyle($li)
    {
        $this->setBasicLIStyle($li);
        $li->getStyle()->setClearToBoth();

        return $this;
    }
}