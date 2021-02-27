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
namespace GI\DOM\HTML\Element\Div\FloatingLayout\Line;

use GI\DOM\HTML\Element\Div\Div;
use GI\DOM\HTML\Element\Div\Float\Clear\Clear;
use GI\DOM\HTML\Element\Div\FloatingLayout\Cell\CellList;

use GI\DOM\HTML\Element\Div\Float\Clear\ClearInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Cell\CellListInterface;

class Line extends Div implements LineInterface
{
    const CELL_CLASS_ID = 'cell';


    /**
     * @var ClearInterface
     */
    private $clear;

    /**
     * @var CellListInterface
     */
    private $childNodes;


    /**
     * Line constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->clear = $this->giGetDi(ClearInterface::class, Clear::class);
    }

    /**
     * @return ClearInterface
     */
    public function getClear()
    {
        return $this->clear;
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
        $this->childNodes = $this->giGetDi(CellListInterface::class, CellList::class);

        return $this;
    }

    /**
     * @param int $cellsNumber
     * @return static
     * @throws \Exception
     */
    public function build(int $cellsNumber)
    {
        $this->getChildNodes()->clean();

        for ($i = 0; $i <= $cellsNumber - 1; $i ++) {
            $this->getChildNodes()->createAndAddCell();
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function compileInnerHTML()
    {
        return parent::compileInnerHTML() . PHP_EOL . $this->clear->toString();
    }
}