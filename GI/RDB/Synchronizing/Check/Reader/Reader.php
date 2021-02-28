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
namespace GI\RDB\Synchronizing\Check\Reader;

use GI\Markup\Reader\AbstractReader;

use GI\Markup\Reader\Branch\BranchInterface;
use GI\Markup\Reader\Leaf\LeafInterface;

/**
 * Class Reader
 * @package GI\RDB\Synchronizing\Check\Reader
 *
 * @method BranchInterface getTable()
 * @method BranchInterface getTable_Column()
 * @method LeafInterface getTable_Column_Name()
 * @method LeafInterface getTable_Column_Contents()
 */
class Reader extends AbstractReader implements ReaderInterface
{
    /**
     * Reader constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->getTable()->getXPath()->setQuery('/tables/table');
        $this->getTable()->getKeyParser()->setToAttribute('name');

        $this->getTable_Column()->getXPath()->setQuery('/table/columns/column');
        $this->getTable_Column()->getKeyParser()->setToAttribute('name');

        $this->getTable_Column_Name()->getXPath()->setQuery('/column');
        $this->getTable_Column_Name()->getKeyParser()->setToConst('name');
        $this->getTable_Column_Name()->getValueParser()->setToAttribute('name');

        $this->getTable_Column_Contents()->getXPath()->setQuery('/column/*');
        $this->getTable_Column_Contents()->getKeyParser()->setToNodeName();
        $this->getTable_Column_Contents()->getValueParser()->setToText();
    }

    /**
     * @return array
     */
    protected function getContents()
    {
         return [
            'table' => [
                'column' => [
                    'name',
                    'contents'
                ]
            ]
        ];
    }
}