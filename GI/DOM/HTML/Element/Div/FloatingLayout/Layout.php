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
namespace GI\DOM\HTML\Element\Div\FloatingLayout;

use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\Div\FloatingLayout\Line\LineList;

use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\Div\Float\Right\RightInterface as FloatRightInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Cell\CellInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Line\LineListInterface;
use GI\DOM\HTML\Element\HTMLInterface;

class Layout extends ContainerElement implements LayoutInterface
{
    const TAG = 'div';


    const LINE_CLASS_ID = 'line';


    /**
     * @var LineListInterface
     */
    private $childNodes;


    /**
     * Layout constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);
    }

    /**
     * @return LineListInterface
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
        $this->childNodes = $this->giGetDi(LineListInterface::class, LineList::class);

        return $this;
    }

    /**
     * @param int $rowsNumber
     * @param int $cellsNumber
     * @param bool $left
     * @return static
     * @throws \Exception
     */
     public function build(int $rowsNumber, int $cellsNumber, bool $left = true)
     {
         $this->getChildNodes()->clean();

         for ($i = 0; $i <= $rowsNumber - 1; $i ++) {
             for ($j = 0; $j <= $cellsNumber - 1; $j ++) {
                 $this->getChildNodes()->createAndAddCell($i, '', $left);
             }
         }

         return $this;
     }

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @return CellInterface
     * @throws \Exception
     */
    public function get(int $rowIndex, int $cellIndex)
    {
        return $this->getChildNodes()->get($rowIndex)->getChildNodes()->get($cellIndex);
    }

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @param string|array|NodeInterface $contents
     * @param string $giId
     * @return static
     * @throws \Exception
     */
     public function set(int $rowIndex, int $cellIndex, $contents, string $giId = '')
     {
         $this->get($rowIndex, $cellIndex)->getChildNodes()->set($contents);

         if (!empty($giId)) {
             $this->get($rowIndex, $cellIndex)->setCellAttribute($giId);
         } elseif (($contents instanceof HTMLInterface) && ($contents->hasGIId())) {
             $this->get($rowIndex, $cellIndex)->setCellAttribute($contents->getGIId());
         }

         return $this;
     }

    /**
     * @param int $rowIndex
     * @param int $cellIndex
     * @param bool|null $left
     * @return bool
     * @throws \Exception
     */
     public function toggleCellFloat(int $rowIndex, int $cellIndex, bool $left = null)
     {
         $cell     = $this->get($rowIndex, $cellIndex);
         $left     = is_bool($left) ? $left : $cell instanceof FloatRightInterface;
         $cellList = $this->getChildNodes()->get($rowIndex)->getChildNodes();

         $cellList->remove($cellIndex);
         $cellList->createAndInsertCell($cellIndex, $cell->getChildNodes()->getItems(), $left);

         return $left;
     }
}