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
namespace GI\DOM\Base\ChildNodesCollection;

use GI\DOM\Base\NodeInterface;

class Alterable extends AbstractImmutable implements AlterableInterface
{
    /**
     * @param string|array|NodeInterface $contents
     * @return static
     */
    public function set($contents)
    {
        parent::set($contents);

        return $this;
    }

    /**
     * @param string|array|NodeInterface $contents
     * @return static
     */
    public function add($contents)
    {
        parent::add($contents);

        return $this;
    }

    /**
     * @param int $index
     * @param string|array|NodeInterface $contents
     * @return static
     */
    public function insert(int $index, $contents)
    {
        parent::insert($index, $contents);

        return $this;
    }
}