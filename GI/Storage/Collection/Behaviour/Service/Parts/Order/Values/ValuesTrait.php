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
namespace GI\Storage\Collection\Behaviour\Service\Parts\Order\Values;

use GI\Storage\Collection\Behaviour\Option\Parts\Order\Values\ValuesInterface as OptionInterface;

trait ValuesTrait
{
    /**
     * @return bool
     */
    public function isOrdered()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->isOrdered();
    }

    /**
     * @return bool|null
     */
    public function getOrdered()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getOrdered();
    }

    /**
     * @param array $items
     * @return static
     */
    public function order(array &$items)
    {
        if ($this->isOrdered()) {
            if ($this->getOrdered()) {
                sort($items);
            } else {
                rsort($items);
            }
        }

        return $this;
    }
}