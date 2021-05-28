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
namespace GI\Storage\Collection\Behaviour\Service\Parts\Bounds\IntBounds;

use GI\Storage\Collection\Behaviour\Option\Parts\Bounds\IntBounds\IntBoundsInterface as OptionInterface;

trait IntBoundsTrait
{
    /**
     * @return int
     */
    public function getMin()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getMin();
    }

    /**
     * @return int
     */
    public function getMax()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getMax();
    }

    /**
     * @param int $item
     * @return static
     * @throws \Exception
     */
    public function validateMin(int $item)
    {
        $min = $this->getMin();

        if (is_int($min) && ($item < $min)) {
            $this->getGiServiceLocator()->throwInvalidMinimumException('Item', $item, $min);
        }

        return $this;
    }

    /**
     * @param int $item
     * @return static
     * @throws \Exception
     */
    public function validateMax(int $item)
    {
        $max = $this->getMax();

        if (is_int($max) && ($item > $max)) {
            $this->getGiServiceLocator()->throwInvalidMaximumException('Item', $item, $max);
        }

        return $this;
    }

    /**
     * @param int $item
     * @return static
     * @throws \Exception
     */
    public function validateBounds(int $item)
    {
        $this->validateMin($item)->validateMax($item);

        return $this;
    }
}