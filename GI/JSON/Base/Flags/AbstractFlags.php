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
namespace GI\JSON\Base\Flags;

use GI\Storage\Collection\BoolCollection\HashSet\Uneditable\AbstractUneditable;

abstract class AbstractFlags extends AbstractUneditable implements FlagsInterface
{
    /**
     * AbstractFlags constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $option = $this->getGiServiceLocator()->getStorageFactory()
            ->getOptionFactory()
            ->createBoolHashSet()
            ->setKeyFormatToUnderlineUpperCase();

        parent::__construct([], $option);
    }

    /**
     * @return int
     */
    public function build()
    {
        $flags = array_filter($this->getItems());
        $flags = array_keys($flags);

        $f = function($carry, $item)
        {
            return $carry | constant($item);
        };

        return array_reduce($flags, $f, 0);
    }
}