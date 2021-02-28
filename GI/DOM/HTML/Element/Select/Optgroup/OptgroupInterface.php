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
namespace GI\DOM\HTML\Element\Select\Optgroup;

use GI\DOM\HTML\Element\Select\Items\ItemInterface;
use GI\DOM\HTML\Element\Select\Option\OptionListInterface;

interface OptgroupInterface extends ItemInterface
{
    /**
     * @param string $label
     * @return static
     * @throws \Exception
     */
    public function setLabel(string $label);

    /**
     * @return OptionListInterface
     */
    public function getChildNodes();
}