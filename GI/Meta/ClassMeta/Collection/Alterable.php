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
namespace GI\Meta\ClassMeta\Collection;

use GI\Meta\ClassMeta\ClassMetaInterface;

class Alterable extends Immutable implements AlterableInterface
{
    /**
     * @param ClassMetaInterface $item
     * @return static
     */
    public function set(ClassMetaInterface $item)
    {
        $this->_set($item);

        return $this;
    }

    /**
     * @param string $class
     * @return static
     * @throws \Exception
     */
    public function setByName(string $class)
    {
        $this->_setByName($class);

        return $this;
    }

    /**
     * @param AlterableInterface $hashSet
     * @return static
     */
    public function merge(AlterableInterface $hashSet)
    {
        $this->_merge($hashSet);

        return $this;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function remove(string $class)
    {
        return $this->_remove($class);
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->_clean();

        return $this;
    }
}