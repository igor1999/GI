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
namespace GI\Component\Table\View\Widget\Template\Column;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\Component\Table\View\Widget\Template\Cell\Header\Ordered\OrderedInterface;
use GI\Component\Table\View\Widget\Template\Cell\Body\Number\NumberInterface;
use GI\Component\Table\View\Widget\WidgetInterface;

class Column implements ColumnInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $headerCellClass;

    /**
     * @var string
     */
    private $bodyCellClass;


    /**
     * Column constructor.
     * @param string $headerCellClass
     * @param string $bodyCellClass
     */
    public function __construct(string $headerCellClass, string $bodyCellClass = '')
    {
        $this->setHeaderCellClass($headerCellClass)->setBodyCellClass($bodyCellClass);
    }

    /**
     * @return string
     */
    public function getHeaderCellClass()
    {
        return $this->headerCellClass;
    }

    /**
     * @param string $headerCellClass
     * @return static
     */
    public function setHeaderCellClass(string $headerCellClass)
    {
        $this->headerCellClass = $headerCellClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyCellClass()
    {
        return $this->bodyCellClass;
    }

    /**
     * @param string $bodyCellClass
     * @return static
     */
    public function setBodyCellClass(string $bodyCellClass)
    {
        $this->bodyCellClass = $bodyCellClass;

        return $this;
    }

    /**
     * @param WidgetInterface $widget
     * @param string $orderCriteria
     * @param bool $orderDirection
     * @return THInterface
     * @throws \Exception
     */
    public function createHeaderCell(WidgetInterface $widget, string $orderCriteria, bool $orderDirection)
    {
        if (!is_a($this->headerCellClass, THInterface::class, true)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Header cell class', $this->headerCellClass, THInterface::class);
        }

        $meta = $this->getGiServiceLocator()->getClassMeta($this->headerCellClass);

        $params = is_a($this->headerCellClass, OrderedInterface::class, true)
            ? [$orderCriteria, $orderDirection]
            : [];

        $params = $this->addWidgetToParams($this->headerCellClass, $params, $widget);

        return $meta->create($params);
    }

    /**
     * @param WidgetInterface $widget
     * @param int $position
     * @param mixed $value
     * @return TDInterface
     * @throws \Exception
     */
    public function createBodyCell(WidgetInterface $widget, int $position, $value)
    {
        if (!is_a($this->bodyCellClass, TDInterface::class, true)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Body cell class', $this->bodyCellClass, TDInterface::class);
        }

        $meta = $this->getGiServiceLocator()->getClassMeta($this->bodyCellClass);

        $params = is_a($this->bodyCellClass, NumberInterface::class, true) ? [$position] : [$value];

        $params = $this->addWidgetToParams($this->bodyCellClass, $params, $widget);

        return $meta->create($params);
    }

    /**
     * @param string $class
     * @param array $params
     * @param WidgetInterface $widget
     * @return array
     * @throws \Exception
     */
    protected function addWidgetToParams(string $class, array $params, WidgetInterface $widget)
    {
        $meta = $this->getGiServiceLocator()->getClassMeta($class);

        $numberOfParams = $meta->getMethods()->get('__construct')->getReflection()->getNumberOfParameters();

        if ($numberOfParams > count($params)) {
            $params[] = $widget;
        }

        return $params;
    }
}