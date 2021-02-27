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
namespace GI\ClientContents\Selection;

use GI\Exception\Common as CommonException;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\Selection\Item\ItemInterface;

trait SelectAllTrait
{
    /**
     * @return static
     * @throws CommonException
     */
    public function selectAll()
    {
        if (!$this->isMulti()) {
            /** @var ServiceLocatorAwareTrait $me */
            $me = $this;
            $me->giThrowCommonException('Selection should be multi');
        }

        /** @var ItemInterface $item */
        foreach ($this->getItems() as $item) {
            $item->setSelected(true);
        }

        return $this;
    }
}