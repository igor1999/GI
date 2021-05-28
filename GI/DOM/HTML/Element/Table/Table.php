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
namespace GI\DOM\HTML\Element\Table;

use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\Table\Items\ItemList;

use GI\DOM\HTML\Element\Table\Row\TRInterface;
use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Table\Items\ItemListInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;

class Table extends ContainerElement implements TableInterface
{
    const TAG   = 'table';


    const ROW_CLASS_ID      = 'row';

    const EVEN_ROW_CLASS_ID = 'even';

    const ODD_ROW_CLASS_ID  = 'odd';


    /**
     * @var ItemListInterface
     */
    private $childNodes;


    /**
     * Table constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);
    }

    /**
     * @return ItemListInterface
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
        $this->childNodes = $this->getGiServiceLocator()->getDependency(ItemListInterface::class, ItemList::class);

        return $this;
    }

    /**
     * @param int $numberOfRows
     * @param int $numberOfCells
     * @param bool $withHeader
     * @return static
     * @throws \Exception
     */
    public function build(int $numberOfRows, int $numberOfCells, bool $withHeader = false)
    {
        $this->getChildNodes()->clean();

        $numberOfRows  = abs((int)$numberOfRows);
        $numberOfCells = abs((int)$numberOfCells);

        if ($withHeader) {
            $numberOfRows += 1;
        }

        for ($i = 0; $i <= $numberOfRows - 1; $i ++) {
            $this->getChildNodes()->addRow();

            /** @var TRInterface $row */
            $row = $this->getChildNodes()->get($i);
            $row->build($numberOfCells, $withHeader && ($i == 0));
        }

        return $this;
    }

    /**
     * @param int $index
     * @return TRInterface
     */
    public function getRow(int $index)
    {
        return $this->getChildNodes()->getRows()[$index];
    }

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @return TDInterface|THInterface
     * @throws \Exception
     */
    public function get(int $rowIndex, int $cellIndex)
    {
        return $this->getRow($rowIndex)->getCell($cellIndex);
    }

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @param string|array|NodeInterface $contents
     * @return static
     * @throws \Exception
     */
    public function set(int $rowIndex, int $cellIndex, $contents)
    {
        $this->get($rowIndex, $cellIndex)->getChildNodes()->set($contents);

        return $this;
    }
}