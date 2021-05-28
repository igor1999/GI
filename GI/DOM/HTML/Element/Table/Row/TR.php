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
namespace GI\DOM\HTML\Element\Table\Row;

use GI\DOM\HTML\Element\ContainerElement;

use GI\DOM\HTML\Element\Table\Cell\CellList;
use GI\DOM\HTML\Element\Table\Cell\CellListInterface;
use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;

class TR extends ContainerElement implements TRInterface
{
    const TAG = 'tr';


    const CELL_CLASS_ID = 'cell';


    /**
     * @var CellListInterface
     */
    private $childNodes;


    /**
     * Row constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);
    }

    /**
     * @return CellListInterface
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
        $this->childNodes = $this->getGiServiceLocator()->getDependency(CellListInterface::class, CellList::class);

        return $this;
    }

    /**
     * @param int $number
     * @param bool $header
     * @return static
     */
    public function build(int $number, bool $header = false)
    {
        $this->getChildNodes()->clean();

        $number = abs((int)$number);

        for ($i = 1; $i <= $number; $i ++) {
            $this->getChildNodes()->createAndAddCell('', $header);
        }

        return $this;
    }

    /**
     * @param int $index
     * @return TDInterface|THInterface
     * @throws \Exception
     */
    public function getCell(int $index)
    {
        return $this->getChildNodes()->get($index);
    }
}