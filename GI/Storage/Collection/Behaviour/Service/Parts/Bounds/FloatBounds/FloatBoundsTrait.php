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
namespace GI\Storage\Collection\Behaviour\Service\Parts\Bounds\FloatBounds;

use GI\Storage\Collection\Behaviour\Option\Parts\Bounds\FloatBounds\FloatBoundsInterface as OptionInterface;

trait FloatBoundsTrait
{
    /**
     * @return float
     */
    public function getMin()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getMin();
    }

    /**
     * @return float
     */
    public function getMax()
    {
        /** @var OptionInterface $option */
        $option = $this->getOption();

        return $option->getMax();
    }

    /**
     * @param float $item
     * @return static
     * @throws \Exception
     */
    public function validateMin(float $item)
    {
        $min = $this->getMin();

        if (is_float($min) && ($item < $min)) {
            $this->getGiServiceLocator()->throwInvalidMinimumException('Item', $item, $min);
        }

        return $this;
    }

    /**
     * @param float $item
     * @return static
     * @throws \Exception
     */
    public function validateMax(float $item)
    {
        $max = $this->getMax();

        if (is_float($max) && ($item > $max)) {
            $this->getGiServiceLocator()->throwInvalidMaximumException('Item', $item, $max);
        }

        return $this;
    }

    /**
     * @param float $item
     * @return static
     * @throws \Exception
     */
    public function validateBounds(float $item)
    {
        $this->validateMin($item)->validateMax($item);

        return $this;
    }
}