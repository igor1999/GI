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
namespace GI\DOM\HTML\Attributes\Name;

use GI\Storage\Collection\StringCollection\ArrayList\Alterable\Alterable as ArrayList;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Name extends ArrayList implements NameInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @return string
     */
    public function renderNameValue()
    {
        $name = '';

        foreach ($this->getItems() as $index => $item) {
            if ($index == 0) {
                $name = $item;
            } else {
                $name .= '[' . $item . ']';
            }
        }

        return $name;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $output = $this->renderNameValue();

        if (!empty($output)) {
            $output = 'name="' . $output . '"';
        }

        return $output;
    }
}