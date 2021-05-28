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
namespace GI\DOM\HTML\Element\Div\Float\Right;

use GI\DOM\HTML\Element\Div\Div;
use GI\DOM\HTML\Attributes\Style\Style;

use GI\DOM\HTML\Attributes\Style\StyleInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Cell\CellTrait;

class Right extends Div implements RightInterface
{
    use CellTrait;


    /**
     * @var StyleInterface
     */
    private $style;


    /**
     * @return static
     * @throws \Exception
     */
    protected function createStyle()
    {
        $this->style = $this->getGiServiceLocator()->getDependency(StyleInterface::class, Style::class, [['float' => 'right']]);

        return $this;
    }

    /**
     * @return StyleInterface
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @return bool
     */
    public function isFloatLeft()
    {
        return false;
    }
}