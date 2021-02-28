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
namespace GI\ClientContents\Selection\Advanced;

use GI\ClientContents\Selection\Item\ItemInterface;

trait UnknownTrait
{
    /**
     * @return bool
     */
    public function hasUnknown()
    {
        return $this->has(UnknownInterface::UNKNOWN_VALUE);
    }

    /**
     * @return ItemInterface
     */
    public function getUnknown()
    {
        return $this->get(UnknownInterface::UNKNOWN_VALUE);
    }

    /**
     * @param bool $selected
     * @return static
     */
    public function addUnknown(bool $selected = true)
    {
        $this->set(
            UnknownInterface::UNKNOWN_VALUE, $this->translate(UnknownInterface::UNKNOWN_TEXT), $selected
        );

        return $this;
    }

    /**
     * @return static
     */
    public function selectUnknown()
    {
        $this->getUnknown()->setSelected(true);

        return $this;
    }

    /**
     * @return static
     */
    public function removeUnknown()
    {
        $this->remove(UnknownInterface::UNKNOWN_VALUE);

        return $this;
    }

}