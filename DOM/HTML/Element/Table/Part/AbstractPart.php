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
namespace GI\DOM\HTML\Element\Table\Part;

use GI\DOM\HTML\Element\ContainerElement;

use GI\DOM\HTML\Element\Table\Row\RowList;
use GI\DOM\HTML\Element\Table\Row\RowListInterface;

abstract class AbstractPart extends ContainerElement implements PartInterface
{
    const TAG = null;


    /**
     * @var RowListInterface
     */
    private $childNodes;


    /**
     * AbstractPart constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);
    }

    /**
     * @return RowListInterface
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
        $this->childNodes = $this->giGetDi(RowListInterface::class, RowList::class);

        return $this;
    }
}