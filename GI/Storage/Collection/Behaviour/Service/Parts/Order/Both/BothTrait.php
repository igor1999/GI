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
namespace GI\Storage\Collection\Behaviour\Service\Parts\Order\Both;

use GI\Storage\Collection\Behaviour\Option\Parts\Order\Both\BothInterface as OptionInterface;

trait BothTrait
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
     * @return bool
     */
    public function isOrderedAsc()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->isOrderedAsc();
    }

    /**
     * @return bool
     */
    public function isOrderedDesc()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->isOrderedDesc();
    }

    /**
     * @return bool
     */
    public function isOrderedKeyAsc()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->isOrderedKeyAsc();
    }

    /**
     * @return bool
     */
    public function isOrderedKeyDesc()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->isOrderedKeyDesc();
    }

    /**
     * @param array $items
     * @return static
     */
    public function order(array &$items)
    {
        if ($this->isOrdered()) {
            if ($this->isOrderedAsc()) {
                asort($items);
            } elseif ($this->isOrderedDesc()) {
                arsort($items);
            } elseif ($this->isOrderedKeyAsc()) {
                ksort($items);
            } elseif ($this->isOrderedKeyDesc()) {
                krsort($items);
            }
        }

        return $this;
    }
}