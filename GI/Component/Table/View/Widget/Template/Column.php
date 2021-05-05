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
namespace GI\Component\Table\View\Widget\Template;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Validation\ValidationTrait;

use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\Component\Table\View\Widget\DOM\Header\Ordered\OrderedInterface;
use GI\Component\Table\View\Widget\DOM\Body\Number\NumberInterface;

class Column implements ColumnInterface
{
    use ServiceLocatorAwareTrait, ValidationTrait;


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
    public function __construct(string $headerCellClass, string $bodyCellClass)
    {
        $this->headerCellClass = $headerCellClass;
        $this->bodyCellClass   = $bodyCellClass;

        $this->validateProperties();
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateHeaderCellClass()
    {
        if (!is_a($this->headerCellClass, THInterface::class, true)) {
            $this->giThrowInvalidTypeException('Header cell class', $this->headerCellClass, THInterface::class);
        }
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateBodyCellClass()
    {
        if (!is_a($this->bodyCellClass, TDInterface::class, true)) {
            $this->giThrowInvalidTypeException('Body cell class', $this->bodyCellClass, TDInterface::class);
        }
    }

    /**
     * @param string $orderCriteria
     * @param bool $orderDirection
     * @return THInterface
     * @throws \Exception
     */
    public function createHeaderCell(string $orderCriteria, bool $orderDirection)
    {
        $meta = $this->giGetClassMeta($this->headerCellClass);

        return is_a($this->headerCellClass, OrderedInterface::class, true)
            ? $meta->create([$orderCriteria, $orderDirection])
            : $meta->create();
    }

    /**
     * @param int $position
     * @param mixed $value
     * @return TDInterface
     * @throws \Exception
     */
    public function createBodyCell(int $position, $value)
    {
        return is_a($this->bodyCellClass, NumberInterface::class, true)
            ? $this->giGetClassMeta($this->bodyCellClass)->create([$position])
            : $this->giGetClassMeta($this->bodyCellClass)->create([$value]);
    }
}