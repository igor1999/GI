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
namespace GI\Component\Table\View\Widget\Template\Cell\Header\Ordered;

use GI\DOM\HTML\Element\Table\Cell\TH\TH;
use GI\ClientContents\TableOrdering\TableOrdering;

use GI\ClientContents\TableOrdering\TableOrderingInterface;
use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;

abstract class AbstractOrdered extends TH implements OrderedInterface
{
    const GI_ID_ORDER_LINK = 'order-link';


    const CLASS_ASCENDANT  = 'gi-order-ascendant';

    const CLASS_DESCENDANT = 'gi-order-descendant';


    const ATTRIBUTE_ORDER_CRITERIA  = 'order-criteria';

    const ATTRIBUTE_ORDER_DIRECTION = 'order-direction';


    /**
     * @var TableOrderingInterface
     */
    private $ordering;

    /**
     * @var HyperlinkInterface
     */
    private $hyperlink;


    /**
     * AbstractOrdered constructor.
     * @param string $actualOrderCriteria
     * @param bool $actualOrderDirection
     * @throws \Exception
     */
    public function __construct(string $actualOrderCriteria, bool $actualOrderDirection)
    {
        parent::__construct();

        $criteria       = $this->getOrderCriteria();
        $direction      = $this->isOrderBothDirections();
        $this->ordering = $this->getGiServiceLocator()->getDependency(
            TableOrderingInterface::class,TableOrdering::class, [$criteria, $direction]
        );

        $this->ordering->setOrdering($actualOrderCriteria, $actualOrderDirection);

        $this->hyperlink = $this->getGiServiceLocator()->getDOMFactory()->createHyperlink('', $this->getCaption())->setHrefToMock();

        $this->hyperlink->getAttributes()
            ->setDataAttribute(static::ATTRIBUTE_ORDER_CRITERIA, $this->ordering->getCriteria())
            ->setDataAttribute(static::ATTRIBUTE_ORDER_DIRECTION, $this->ordering->getNextDirectionAsString());
    }

    /**
     * @return string
     */
    abstract protected function getOrderCriteria();

    /**
     * @return bool
     */
    abstract protected function isOrderBothDirections();

    /**
     * @return TableOrderingInterface
     */
    protected function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @return string
     */
    abstract protected function getCaption();

    /**
     * @return HyperlinkInterface
     */
    protected function getHyperlink()
    {
        return $this->hyperlink;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function compile()
    {
        if ($this->getOrdering()->isAscendant()) {
            $this->getClasses()->add(static::CLASS_ASCENDANT);
        } elseif ($this->getOrdering()->isDescendant()) {
            $this->getClasses()->add(static::CLASS_DESCENDANT);
        }

        $this->getChildNodes()->set($this->getHyperlink());

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $this->compile();

        return parent::toString();
    }
}