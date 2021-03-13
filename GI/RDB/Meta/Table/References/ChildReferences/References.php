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
namespace GI\GI\RDB\Meta\Table\References\ChildReferences;

use GI\GI\RDB\Meta\Table\References\Base\AbstractReferences as Base;

use GI\RDB\Meta\Table\TableInterface;

class References extends Base implements ReferencesInterface
{
    /**
     * @return array
     */
    protected function getContents()
    {
        return $this->getTable()->getChildReferences();
    }

    /**
     * @param TableInterface $table
     * @return bool
     */
    protected function isRelationUnique(TableInterface $table)
    {
        $f = function(array $row) use ($table)
        {
            return $row['referenced_table'] == $table->getName();
        };
        $contents = array_filter($this->getContents(), $f);

        $unique = false;
        foreach ($contents as $row) {
            $name = $row['referenced_column'];

            if ($table->getColumnList()->get($name)->isUnique()) {
                $unique =true;
                break;
            }
        }

        return $unique;
    }

    /**
     * @param string $name
     * @return bool
     * @throws \Exception
     */
    public function isUnique(string $name)
    {
        return $this->isRelationUnique($this->get($name));
    }

    /**
     * @return TableInterface[]
     */
    public function getUniqueItems()
    {
        $f = function(TableInterface $table)
        {
            return $this->isRelationUnique($table);
        };

        return array_filter($this->getItems(), $f);
    }

    /**
     * @return TableInterface[]
     */
    public function getNonUniqueItems()
    {
        $f = function(TableInterface $table)
        {
            return !$this->isRelationUnique($table);
        };

        return array_filter($this->getItems(), $f);
    }
}